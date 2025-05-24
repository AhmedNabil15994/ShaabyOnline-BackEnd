<?php

namespace Modules\Advertising\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Advertising\Http\Requests\Dashboard\AdvertisingRequest;
use Modules\Advertising\Transformers\Dashboard\AdvertisingResource;
use Modules\Advertising\Repositories\Dashboard\AdvertisingRepository as Advertising;
use Modules\Advertising\Repositories\Dashboard\AdvertisingGroupRepository as AdvertisingGroup;

class AdvertisingController extends Controller
{
    protected $advertising;
    protected $adGroup;

    function __construct(Advertising $advertising, AdvertisingGroup $adGroup)
    {
        $this->advertising = $advertising;
        $this->adGroup = $adGroup;
    }

    public function index(Request $request)
    {
        $advertisingGroup = $this->adGroup->findById($request->advertising_group);
        if (!$advertisingGroup)
            abort(404);

        return view('advertising::dashboard.advertising.index', compact('advertisingGroup'));
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->advertising->QueryTable($request));
        $datatable['data'] = AdvertisingResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create(Request $request)
    {
        $advertisingGroup = $this->adGroup->findById($request->advertising_group);
        if (!$advertisingGroup)
            abort(404);

        $groups = $this->adGroup->getAll();
        return view('advertising::dashboard.advertising.create', compact('groups', 'advertisingGroup'));
    }

    public function store(AdvertisingRequest $request)
    {
        try {
            $create = $this->advertising->create($request);

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
        return view('advertising::dashboard.advertising.show');
    }

    public function edit($id)
    {
        $advertising = $this->advertising->findById($id);
        if (!$advertising)
            abort(404);

        $groups = $this->adGroup->getAll();
        return view('advertising::dashboard.advertising.edit', compact('advertising', 'groups'));
    }

    public function update(AdvertisingRequest $request, $id)
    {
        try {
            $update = $this->advertising->update($request, $id);

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
            $delete = $this->advertising->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->advertising->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
