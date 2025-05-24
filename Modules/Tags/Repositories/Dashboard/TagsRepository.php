<?php

namespace Modules\Tags\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Core\Traits\CoreTrait;
use Modules\Tags\Entities\Tag;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\SyncRelationModel;

class TagsRepository
{
    use SyncRelationModel, CoreTrait;

    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $tags = $this->tag->orderBy($order, $sort)->get();
        return $tags;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $tags = $this->tag->orderBy($order, $sort)->active()->get();
        return $tags;
    }

    public function findById($id)
    {
        $tag = $this->tag->withDeleted()->find($id);
        return $tag;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'color' => $request->color ?? null,
                'background' => $request->background ?? null,
                "title"=>$request->title,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.tag_img_path')), $request->image);
                $data['image'] = config('core.config.tag_img_path') . '/' . $imgName;
            } else {
                $data['image'] = null;
            }

            $tag = $this->tag->create($data);

            // $this->translateTable($tag, $request);

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
        $tag = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($tag) : null;

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'color' => $request->color ?? null,
                'background' => $request->background ?? null,
                "title"=>$request->title,
            ];

            if ($request->image) {
                if (!empty($tag->image) && !in_array($tag->image, config('core.config.special_images'))) {
                    File::delete($tag->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.tag_img_path')), $request->image);
                $data['image'] = config('core.config.tag_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $tag->image;
            }

            $tag->update($data);

            // $this->translateTable($tag, $request);

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

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
        }
        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $model = $this->findById($id);

            if ($model->trashed()):
                $model->forceDelete(); else:
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
        $query = $this->tag->query();

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
