<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Http\Requests\Dashboard\DeliveryChargeRequest;
use Modules\Vendor\Repositories\Dashboard\DeliveryChargeRepository as DeliveryCharge;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Modules\Vendor\Transformers\Dashboard\VendorDeliveryChargeResource;

class DeliveryChargeController extends Controller
{
    protected $vendor;
    protected $deliveryCharge;

    public function __construct(DeliveryCharge $deliveryCharge, Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->deliveryCharge = $deliveryCharge;
    }

    public function index()
    {
        return view('vendor::dashboard.delivery-charges.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->vendor->QueryTable($request));
        $datatable['data'] = VendorDeliveryChargeResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function edit($id)
    {
        $vendor = $this->vendor->findById($id);
        if (!$vendor) {
            abort(404);
        }

        $charges = $vendor->deliveryCharge()->pluck('delivery', 'state_id')->toArray();
        // $times = $vendor->deliveryCharge()->pluck('delivery_time', 'state_id')->toArray();
        $times = $vendor->deliveryCharge()->get(['delivery_time', 'state_id'])->toArray();
        $statuses = $vendor->deliveryCharge()->pluck('status', 'state_id')->toArray();
        $min_order_amounts = $vendor->deliveryCharge()->pluck('min_order_amount', 'state_id')->toArray();

        return view('vendor::dashboard.delivery-charges.edit', compact('vendor', 'charges', 'times', 'statuses', 'min_order_amounts'));
    }

    public function update(DeliveryChargeRequest $request, $vendorId)
    {
        try {
            $vendor = $this->vendor->findById($vendorId);
            $update = $this->deliveryCharge->update($request, $vendor);

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
            $delete = $this->deliveryCharge->delete($id);

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
            $deleteSelected = $this->deliveryCharge->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
