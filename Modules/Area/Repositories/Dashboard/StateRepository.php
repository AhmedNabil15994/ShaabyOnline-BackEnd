<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Area\Entities\State;
use Hash;
use Illuminate\Support\Facades\DB;

class StateRepository
{
    protected $state;

    function __construct(State $state)
    {
        $this->state   = $state;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->state->orderBy($order, $sort)->get();
    }

    public function getAllActive($order = 'id', $sort = 'desc', $cityId = null, $countryId = null)
    {
        $query = $this->state->active();

        if (!is_null($cityId)) {
            $query = $query->where('city_id', $cityId);
        }

        if (!is_null($countryId)) {
            $query = $query->whereHas('city.country', function ($query) use ($countryId) {
                $query = $query->where('id', $countryId);
            });
        }

        return $query->orderBy($order, $sort)->get();
    }

    public function getAllByCityId($cityId)
    {
        $states = $this->state->where('city_id', $cityId)->get();
        return $states;
    }

    public function findById($id)
    {
        $state = $this->state->withDeleted()->find($id);
        return $state;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $state = $this->state->create([
                'city_id'      => $request->city_id,
                'status'       => $request->status ? 1 : 0,
                "title" => $request->title,
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

        $state = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($state) : null;

        try {

            $state->update([
                'city_id'      => $request->city_id,
                'status'       => $request->status ? 1 : 0,
                "title" => $request->title,
            ]);



            DB::commit();
            return true;
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

            $city = $this->findById($id);

            if ($city->trashed()) :
                $city->forceDelete();
            else :
                $city->delete();
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
        $query = $this->state->with(['city'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search State by Created Dates
        if (isset($request['req']['from']) && $request['req']['from'] != '')
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']) && $request['req']['to'] != '')
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }
}
