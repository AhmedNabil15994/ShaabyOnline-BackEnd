<?php

namespace Modules\Advertising\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Advertising\Http\Requests\Dashboard\AdvertisingGroupRequest;
use Modules\Advertising\Transformers\Dashboard\AdvertisingGroupResource;
use Modules\Advertising\Repositories\Dashboard\AdvertisingGroupRepository as AdvertisingGroup;

class AdvertisingGroupController extends Controller
{
    protected $adGroup;

    function __construct(AdvertisingGroup $adGroup)
    {
        $this->adGroup = $adGroup;
    }

    public function index(Request $request)
    {
        $items = $this->adGroup->QueryTable($request)->get();
        return view('advertising::dashboard.advertising_groups.index', compact('items'));
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->adGroup->QueryTable($request));

        $datatable['data'] = AdvertisingGroupResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('advertising::dashboard.advertising_groups.create');
    }

    public function store(AdvertisingGroupRequest $request)
    {
        try {
            $create = $this->adGroup->create($request);

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
        abort(404);
        return view('advertising::dashboard.advertising_groups.show');
    }

    public function edit($id)
    {
        $adGroup = $this->adGroup->findById($id);
        if (!$adGroup)
            abort(404);

        return view('advertising::dashboard.advertising_groups.edit', compact('adGroup'));
    }

    public function clone($id)
    {
        $adGroup = $this->adGroup->findById($id);

        return view('advertising::dashboard.advertising_groups.clone', compact('adGroup'));
    }

    public function update(AdvertisingGroupRequest $request, $id)
    {
        try {
            $update = $this->adGroup->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function changeAdvertGroupStatus(Request $request)
    {
        try {
            $update = $this->adGroup->updateAdvertGroupStatus($request);

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
            $delete = $this->adGroup->delete($id);

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
            $deleteSelected = $this->adGroup->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\Exception $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
