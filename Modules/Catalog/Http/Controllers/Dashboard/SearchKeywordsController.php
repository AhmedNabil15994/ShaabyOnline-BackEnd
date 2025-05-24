<?php

namespace Modules\Catalog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Catalog\Http\Requests\Dashboard\SearchKeywordsRequest;
use Modules\Catalog\Transformers\Dashboard\SearchKeywordsResource;
use Modules\Catalog\Repositories\Dashboard\SearchKeywordsRepository as SearchKeyword;

class SearchKeywordsController extends Controller
{
    protected $searchKeyword;

    function __construct(SearchKeyword $searchKeyword)
    {
        $this->searchKeyword = $searchKeyword;
    }

    public function index()
    {
        return view('catalog::dashboard.search_keywords.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->searchKeyword->QueryTable($request));
        $datatable['data'] = SearchKeywordsResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('catalog::dashboard.search_keywords.create');
    }

    public function store(SearchKeywordsRequest $request)
    {
        try {
            $create = $this->searchKeyword->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('catalog::dashboard.search_keywords.show');
    }

    public function edit($id)
    {
        $searchKeyword = $this->searchKeyword->findById($id);
        if (!$searchKeyword)
            abort(404);
        return view('catalog::dashboard.search_keywords.edit', compact('searchKeyword'));
    }

    public function clone($id)
    {
        $searchKeyword = $this->searchKeyword->findById($id);
        if (!$searchKeyword)
            abort(404);
        return view('catalog::dashboard.search_keywords.clone', compact('searchKeyword'));
    }

    public function update(SearchKeywordsRequest $request, $id)
    {
        try {
            $update = $this->searchKeyword->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->searchKeyword->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->searchKeyword->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
