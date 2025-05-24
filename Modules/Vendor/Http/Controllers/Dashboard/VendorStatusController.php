<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Http\Requests\Dashboard\VendorStatusRequest;
use Modules\Vendor\Transformers\Dashboard\VendorStatusResource;
use Modules\Vendor\Repositories\Dashboard\VendorStatusRepository as VendorStatus;

class VendorStatusController extends Controller
{

    function __construct(VendorStatus $vendorStatuses)
    {
        $this->vendorStatuses = $vendorStatuses;
    }

    public function index()
    {
        return view('vendor::dashboard.vendor_statuses.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->vendorStatuses->QueryTable($request));

        $datatable['data'] = VendorStatusResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('vendor::dashboard.vendor_statuses.create');
    }

    public function store(VendorStatusRequest $request)
    {
        try {
            $create = $this->vendorStatuses->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        abort(404);
        return view('vendor::dashboard.vendor_statuses.show');
    }

    public function edit($id)
    {
        $vendor_status = $this->vendorStatuses->findById($id);
        
        return view('vendor::dashboard.vendor_statuses.edit',compact('vendor_status'));
    }

    public function update(VendorStatusRequest $request, $id)
    {
        try {
            $update = $this->vendorStatuses->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->vendorStatuses->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->vendorStatuses->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
