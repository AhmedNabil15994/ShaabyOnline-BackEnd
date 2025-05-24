<?php

namespace Modules\Catalog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Catalog\Http\Requests\Dashboard\CategoryRequest;
use Modules\Catalog\Http\Requests\Dashboard\updatePhotoRequest;
use Modules\Catalog\Transformers\Dashboard\CategoryResource;
use Modules\Catalog\Repositories\Dashboard\CategoryRepository as Category;

class CategoryController extends Controller
{
    protected $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return view('catalog::dashboard.categories.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->category->QueryTable($request));
        $datatable['data'] = CategoryResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('catalog::dashboard.categories.create');
    }

    public function store(CategoryRequest $request)
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
        abort(404);
        return view('catalog::dashboard.categories.show');
    }

    public function edit($id)
    {
        $category = $this->category->findById($id);
        if (!$category) {
            abort(404);
        }
        return view('catalog::dashboard.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
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

    public function updatePhoto(updatePhotoRequest $request)
    {
        try {
            $imagePath = $this->category->updatePhoto($request);

            if ($imagePath) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success'), 'imagePath' => $imagePath]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            throw $e;
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
