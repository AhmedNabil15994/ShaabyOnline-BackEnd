<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\CoreTrait;
use Modules\Vendor\Entities\VendorCategory;

class CategoryRepository
{
    use CoreTrait;

    protected $category;

    function __construct(VendorCategory $category)
    {
        $this->category = $category;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->category->orderBy($order, $sort)->get();
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->category->active()->orderBy($order, $sort)->get();
    }

    public function mainCategories($order = 'sort', $sort = 'asc')
    {
        $categories = $this->category->mainCategories()->orderBy($order, $sort)->get();
        return $categories;
    }

    public function findById($id)
    {
        $category = $this->category->withDeleted()->find($id);
        return $category;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'show_in_home' => $request->show_in_home ? 1 : 0,
                'vendor_category_id' => !empty($request->vendor_category_id) && $request->vendor_category_id != "null" ? $request->vendor_category_id : null,
                'color' => $request->color ?? null,
                'sort' => $request->sort ?? 0,
                'title' => $request->title,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.vendor_category_img_path')), $request->image);
                $data['image'] = config('core.config.vendor_category_img_path') . '/' . $imgName;
            } else {
                $data['image'] = url(config('setting.images.logo'));
            }

            if (!is_null($request->cover)) {
                $imgName = $this->uploadImage(public_path(config('core.config.vendor_category_img_path')), $request->cover);
                $data['cover'] = config('core.config.vendor_category_img_path') . '/' . $imgName;
            } else {
                $data['cover'] = url(config('setting.images.logo'));
            }

            $category = $this->category->create($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $category = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($category) : null;

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'show_in_home' => $request->show_in_home ? 1 : 0,
                'vendor_category_id' => !empty($request->vendor_category_id) && $request->vendor_category_id != "null" ? $request->vendor_category_id : null,
                'color' => $request->color ?? null,
                'sort' => $request->sort ?? 0,
                'title' => $request->title,
            ];

            if ($request->image) {
                if (!empty($category->image) && !in_array($category->image, config('core.config.special_images'))) {
                    File::delete($category->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.vendor_category_img_path')), $request->image);
                $data['image'] = config('core.config.vendor_category_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $category->image;
            }

            if ($request->cover) {
                if (!empty($category->cover) && !in_array($category->cover, config('core.config.special_images'))) {
                    File::delete($category->cover); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.vendor_category_img_path')), $request->cover);
                $data['cover'] = config('core.config.vendor_category_img_path') . '/' . $imgName;
            } else {
                $data['cover'] = $category->cover;
            }

            $category->update($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
        return true;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);
            if ($model && !empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                File::delete($model->image); ### Delete old image
            }

            if ($model && !empty($model->cover) && !in_array($model->cover, config('core.config.special_images'))) {
                File::delete($model->cover); ### Delete old image
            }

            if ($model->trashed()) :
                $model->forceDelete();
            else :
                $model->delete();
            endif;

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                if ($id != 1)
                    $model = $this->delete($id);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->category->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        // Search Categories by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) && $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) && $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }
}
