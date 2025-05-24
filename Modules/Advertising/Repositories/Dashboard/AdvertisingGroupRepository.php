<?php

namespace Modules\Advertising\Repositories\Dashboard;

use Modules\Advertising\Entities\AdvertisingGroup;
use Illuminate\Support\Facades\DB;

class AdvertisingGroupRepository
{
    protected $adGroup;

    function __construct(AdvertisingGroup $adGroup)
    {
        $this->adGroup = $adGroup;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->adGroup->orderBy($order, $sort)->get();
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->adGroup->orderBy($order, $sort)->active()->get();
    }

    public function findById($id)
    {
        return $this->adGroup->withDeleted()->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $tag = $this->adGroup->create([
                'status' => $request->status ? 1 : 0,
                'sort' => $request->sort ?? 0,
                'position' => $request->position ?? null,
                "title"   => $request->title
            ]);



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

            $tag->update([
                'status' => $request->status ? 1 : 0,
                'sort' => $request->sort ?? 0,
                'position' => $request->position ?? null,
                "title"   => $request->title
            ]);



            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateAdvertGroupStatus($request)
    {
        DB::beginTransaction();
        $item = $this->findById($request->id);

        try {

            if ($item) {
                $item->update([
                    'status' => $request->status,
                ]);

                DB::commit();
                return true;

            } else {
                return false;
            }

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

            if ($model->trashed()):
                $model->forceDelete();
            else:
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
        $query = $this->adGroup->query();

        $query->where(function ($query) use ($request) {
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
