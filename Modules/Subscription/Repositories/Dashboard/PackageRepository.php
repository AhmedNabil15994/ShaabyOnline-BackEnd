<?php

namespace Modules\Subscription\Repositories\Dashboard;

use Modules\Subscription\Entities\Package;
use Hash;
use DB;

class PackageRepository
{
    public function __construct(Package $package)
    {
        $this->package = $package;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $packages = $this->package->orderBy($order, $sort)->get();
        return $packages;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $packages = $this->package->active()->orderBy($order, $sort)->get();
        return $packages;
    }

    public function findById($id)
    {
        $package = $this->package->withDeleted()->find($id);
        return $package;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $package = $this->package->create([
                'price' => $request->price,
                'months' => $request->months,
                'special_price' => $request->special_price,
                'status' => $request->status ? 1 : 0,
                "title"=> $request->title,
                "description"=> $request->description,
                "seo_description"=> $request->seo_description,
                "seo_keywords"=> $request->seo_keywords,
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

        $package = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($package) : null;

        try {
            $package->update([
                'price' => $request->price,
                'months' => $request->months,
                'special_price' => $request->special_price,
                'status' => $request->status ? 1 : 0,
                "title"=> $request->title,
                "description"=> $request->description,
                "seo_description"=> $request->seo_description,
                "seo_keywords"=> $request->seo_keywords,
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

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
            $model->translateOrNew($locale)->description = isset($request['description']) && !empty($request['description']) ? $request['description'][$locale] : null;
            $model->translateOrNew($locale)->seo_description = isset($request['seo_description']) && !empty($request['seo_description']) ? $request['seo_description'][$locale] : null;
            $model->translateOrNew($locale)->seo_keywords = isset($request['seo_keywords']) && !empty($request['seo_keywords']) ? $request['seo_keywords'][$locale] : null;
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
        $query = $this->package->query()
            ->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('price', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('months', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('special_price', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere(function ($query) use ($request) {
                    $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                });
            });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // Search Pages by Created Dates
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
