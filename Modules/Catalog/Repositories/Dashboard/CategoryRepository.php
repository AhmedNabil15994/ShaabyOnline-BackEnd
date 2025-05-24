<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Modules\Catalog\Entities\Category;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Core\Traits\Attachment\Attachment;
use Modules\Core\Traits\CoreTrait;

class CategoryRepository
{
    use CoreTrait;

    protected $category;
    protected $imgPath;

    public function __construct(Category $category)
    {
        $this->category = $category;
        $this->imgPath = public_path('uploads/categories');
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
                /* 'image' => $request->image ? path_without_domain($request->image) : url(config('setting.images.logo')),
                'cover' => $request->cover ? path_without_domain($request->cover) : url(config('setting.images.logo')), */
                'status' => $request->status ? 1 : 0,
                'show_in_home' => $request->show_in_home ? 1 : 0,
                'category_id' => ($request->category_id != "null" && $request->category_id != 1) ? $request->category_id : null,
                'color' => $request->color ?? null,
                'sort' => $request->sort ?? 0,
                "title" => $request->title,
                "seo_description" => $request->seo_description,
                "seo_keywords"   => $request->seo_keywords
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage($this->imgPath, $request->image);
                $data['image'] = 'uploads/categories/' . $imgName;
            } else {
                $data['image'] = url(config('setting.images.logo'));
            }

            if (!is_null($request->cover)) {
                $imgName = $this->uploadImage($this->imgPath, $request->cover);
                $data['cover'] = 'uploads/categories/' . $imgName;
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
        $restore = $request->restore ? $this->restoreSoftDelte($category) : null;

        try {

            $data = [
                /* 'image' => $request->image ? path_without_domain($request->image) : $category->image,
                'cover' => $request->cover ? path_without_domain($request->cover) : $category->cover, */
                'status' => $request->status ? 1 : 0,
                'show_in_home' => $request->show_in_home ? 1 : 0,
                'category_id' => ($request->category_id != "null" && $request->category_id != 1) ? $request->category_id : null,
                'color' => $request->color ?? null,
                'sort' => $request->sort ?? 0,
                "title" => $request->title,
                "seo_description" => $request->seo_description,
                "seo_keywords"   => $request->seo_keywords
            ];

            if ($request->image) {
                File::delete($category->image); ### Delete old image
                $imgName = $this->uploadImage($this->imgPath, $request->image);
                $data['image'] = 'uploads/categories/' . $imgName;
            } else {
                $data['image'] = $category->image;
            }

            if ($request->cover) {
                File::delete($category->cover); ### Delete old image
                $imgName = $this->uploadImage($this->imgPath, $request->cover);
                $data['cover'] = 'uploads/categories/' . $imgName;
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

    public function updatePhoto($request)
    {
        DB::beginTransaction();

        $category = $this->findById($request->photo_id);

        try {

            if (auth()->user()->can('edit_products_image') && $request->image) {

                $category->update([
                    'image' => $request->image ? Attachment::updateAttachment($request['image'], $category->image, 'categories') : $category->image
                ]);

                DB::commit();
                $category->fresh();
                return asset($category->image);
            }

            return false;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }



    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model) {
                if ($model->trashed()) {
                    if (!empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                        File::delete($model->image);
                    }
                    if (!empty($model->cover) && !in_array($model->cover, config('core.config.special_images'))) {
                        File::delete($model->cover);
                    }
                    $model->forceDelete();
                } else {
                    $model->delete();
                }
            }

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
        $query = $this->category
            ->where(function ($query) use ($request) {
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
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }
}
