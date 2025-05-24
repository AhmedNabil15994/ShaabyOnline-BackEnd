<?php

namespace Modules\Catalog\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Transformers\Dashboard\AddonDetailsResource;
use Modules\Catalog\Transformers\Dashboard\SimpleAddonOptionsResource;
use Modules\Core\Traits\DataTable;
use Modules\Catalog\Http\Requests\Dashboard\AddonOptionRequest;
use Modules\Catalog\Transformers\Dashboard\AddonOptionResource;
use Modules\Catalog\Repositories\Dashboard\AddonOptionRepository as AddonOption;

class AddonOptionsController extends Controller
{
    protected $addonOption;

    function __construct(AddonOption $addonOption)
    {
        $this->addonOption = $addonOption;
    }

    public function index()
    {
        return view('catalog::dashboard.addon_options.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->addonOption->QueryTable($request));
        $datatable['data'] = AddonOptionResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function getAddonOptionsByCategory(Request $request)
    {
        $addonOptions = $this->addonOption->getAddonOptionsByCategory($request->addon_category_id ?? null);
        $data['product_addon'] = $this->addonOption->checkProductAddonByProductAndCategory($request->product_id ?? null, $request->addon_category_id ?? null);
        $data['options'] = SimpleAddonOptionsResource::collection($addonOptions);
        return Response()->json(['status' => true, 'data' => $data]);
    }

    public function getAddonDetails(Request $request)
    {
        $addon = $this->addonOption->getAddonDetails($request->product_addon_id ?? null);
        return Response()->json(['status' => true, 'data' => new AddonDetailsResource($addon)]);
    }

    public function create()
    {
        return view('catalog::dashboard.addon_options.create');
    }

    public function store(AddonOptionRequest $request)
    {
        try {
            $create = $this->addonOption->create($request);

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
        $category = $this->addonOption->findById($id);
        if (!$category)
            abort(404);

        return view('catalog::dashboard.addon_options.show');
    }

    public function edit($id)
    {
        $addonOption = $this->addonOption->findById($id);
        if (!$addonOption)
            abort(404);

        return view('catalog::dashboard.addon_options.edit', compact('addonOption'));
    }

    public function update(AddonOptionRequest $request, $id)
    {
        try {
            $update = $this->addonOption->update($request, $id);

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
                $delete = $this->addonOption->delete($id);

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
            $deleteSelected = $this->addonOption->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
