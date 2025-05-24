<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Core\Traits\CoreTrait;
use Modules\Catalog\Entities\HomeCategory;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\SyncRelationModel;

class HomeCategoryRepository
{
    use SyncRelationModel, CoreTrait;

    protected $homeCategory;

    public function __construct(HomeCategory $homeCategory)
    {
        $this->homeCategory = $homeCategory;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $homeCategories = $this->homeCategory->orderBy($order, $sort)->get();
        return $homeCategories;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $homeCategories = $this->homeCategory->orderBy($order, $sort)->active()->get();

        return $homeCategories;
    }

    public function findById($id)
    {
        $homeCategory = $this->homeCategory->withDeleted()->find($id);
        return $homeCategory;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'sort' => $request->sort ?? 1,
                "title" => $request->title,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.homeCategory_img_path')), $request->image);
                $data['image'] = config('core.config.homeCategory_img_path') . '/' . $imgName;
            } else {
                $data['image'] = "/uploads/default.png";
            }

            $homeCategory = $this->homeCategory->create($data);


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
        $homeCategory = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($homeCategory) : null;

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                "title" => $request->title,
                'sort' => $request->sort ?? 1,
            ];

            if ($request->image) {
                if (!empty($homeCategory->image) && !in_array($homeCategory->image, config('core.config.special_images'))) {
                    File::delete($homeCategory->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.homeCategory_img_path')), $request->image);
                $data['image'] = config('core.config.homeCategory_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $homeCategory->image;
            }

            $homeCategory->update($data);

            // $this->translateTable($homeCategory, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        return $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model) {
                if ($model->trashed()) {
                    if (!empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                        File::delete($model->image); ### Delete old image
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
        $query = $this->homeCategory->query();

        $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
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
