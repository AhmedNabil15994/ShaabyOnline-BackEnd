<?php

namespace Modules\Apps\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Modules\Vendor\Repositories\Dashboard\VendorStatusRepository as VendorStatus;

class VendorController extends Controller
{
    protected $vendorStatuses;
    protected $vendor;

    function __construct(Vendor $vendor, VendorStatus $vendorStatuses)
    {
        $this->vendorStatuses = $vendorStatuses;
        $this->vendor = $vendor;
    }

    public function index()
    {
        return view('apps::vendor.index');
    }

    public function editVendorInfo(Request $request)
    {
        $vendor = $this->vendor->findById($request->id);
        if (!$vendor)
            abort(404);

        return view('apps::vendor.edit', compact('vendor'));
    }

    public function updateVendorInfo(Request $request, $id)
    {
        try {
            $update = $this->vendor->updateVendorStatus($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}
