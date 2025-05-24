<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Modules\Catalog\Entities\SearchKeyword;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\SyncRelationModel;

class SearchKeywordsRepository
{
    use SyncRelationModel;

    protected $searchKeyword;

    function __construct(SearchKeyword $searchKeyword)
    {
        $this->searchKeyword = $searchKeyword;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $searchKeywords = $this->searchKeyword->orderBy($order, $sort)->get();
        return $searchKeywords;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $searchKeywords = $this->searchKeyword->orderBy($order, $sort)->active()->get();
        return $searchKeywords;
    }

    public function findById($id)
    {
        $searchKeyword = $this->searchKeyword->withDeleted()->find($id);
        return $searchKeyword;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $searchKeyword = $this->searchKeyword->create([
                'title' => $request->title,
                'status' => $request->status ? 1 : 0,
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
        $searchKeyword = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($searchKeyword) : null;

        try {

            $searchKeyword->update([
                'title' => $request->title,
                'status' => $request->status ? 1 : 0,
            ]);

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
        $query = $this->searchKeyword->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
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
