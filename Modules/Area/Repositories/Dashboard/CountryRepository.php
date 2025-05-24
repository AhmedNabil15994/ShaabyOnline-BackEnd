<?php

namespace Modules\Area\Repositories\Dashboard;

use Modules\Area\Entities\Country;
use Hash;
use Illuminate\Support\Facades\DB;

class CountryRepository
{
    protected $country;

    function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        return $this->country->orderBy($order, $sort)->get();
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->country->active()->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        $country = $this->country->withDeleted()->find($id);
        return $country;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $country = $this->country->create([
                'status' => $request->status ? 1 : 0,
                'code' => $request->code ?? null,
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

        $country = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($country) : null;

        try {

            $country->update([
                'status' => $request->status ? 1 : 0,
                'code' => $request->code ?? null,
                "title" => $request->title,
            ]);



            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($country)
    {
        $country->restore();
    }



    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $country = $this->findById($id);

            if ($country->trashed()) :
                $country->forceDelete();
            else :
                $country->delete();
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
        $query = $this->country->with([])->where(function ($query) use ($request) {
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
        // Search Countries by Created Dates
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

    public function createFromSettings($data)
    {
        DB::beginTransaction();

        try {

            foreach ($data as $k => $v) {

                $country = $this->country->create([
                    'code' => $v['code'] ?? null,
                    'status' => $v['status'] ? 1 : 0,
                ]);

                $this->translateTable($country, $v);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
