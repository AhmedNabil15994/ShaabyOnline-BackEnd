<?php

namespace Modules\Catalog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;

use Modules\Catalog\Http\Requests\Dashboard\HomeCategoryRequest;
use Modules\Catalog\Transformers\Dashboard\HomeCategoryResource;
use \Modules\Catalog\Repositories\Dashboard\HomeCategoryRepository as HomeCategory;

class HomeCategoryController extends Controller
{
    protected $home_category;

    function __construct(HomeCategory $home_category)
    {
        $this->home_category = $home_category;
    }

    public function index()
    {
        return view('catalog::dashboard.home_categories.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->home_category->QueryTable($request));
        $datatable['data'] = HomeCategoryResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('catalog::dashboard.home_categories.create');
    }

    public function store(HomeCategoryRequest $request)
    {
        try {
            $create = $this->home_category->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            throw $e;
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('catalog::dashboard.home_categories.show');
    }

    public function edit($id)
    {
        $model = $this->home_category->findById($id);
        if (!$model)
            abort(404);
        return view('catalog::dashboard.home_categories.edit', compact('model'));
    }

    public function clone($id)
    {
        $home_category = $this->home_category->findById($id);
        if (!$home_category)
            abort(404);
        return view('catalog::dashboard.home_categories.clone', compact('home_category'));
    }

    public function update(HomeCategoryRequest $request, $id)
    {
        try {
            $update = $this->home_category->update($request, $id);

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
            $delete = $this->home_category->delete($id);

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
            $deleteSelected = $this->home_category->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
