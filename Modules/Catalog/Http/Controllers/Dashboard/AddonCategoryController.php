<?php

namespace Modules\Catalog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Catalog\Http\Requests\Dashboard\AddonCategoryRequest;
use Modules\Catalog\Transformers\Dashboard\AddonCategoryResource;
use Modules\Catalog\Repositories\Dashboard\AddonCategoryRepository as AddonCategory;

class AddonCategoryController extends Controller
{
    protected $category;

    function __construct(AddonCategory $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return view('catalog::dashboard.addon_categories.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->category->QueryTable($request));
        $datatable['data'] = AddonCategoryResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('catalog::dashboard.addon_categories.create');
    }

    public function store(AddonCategoryRequest $request)
    {
        try {
            $create = $this->category->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        $category = $this->category->findById($id);
        if (!$category)
            abort(404);

        return view('catalog::dashboard.addon_categories.show');
    }

    public function edit($id)
    {
        $category = $this->category->findById($id);
        if (!$category)
            abort(404);

        return view('catalog::dashboard.addon_categories.edit', compact('category'));
    }

    public function update(AddonCategoryRequest $request, $id)
    {
        try {
            $update = $this->category->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = false;
            if ($id != 1)
                $delete = $this->category->delete($id);

            if ($delete)
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->category->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
