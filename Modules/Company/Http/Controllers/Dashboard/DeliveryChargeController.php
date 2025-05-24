<?php

namespace Modules\Company\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Company\Http\Requests\Dashboard\DeliveryChargeRequest;
use Modules\Company\Transformers\Dashboard\CompanyResource;
use Modules\Company\Repositories\Dashboard\CompanyRepository as Company;
use Modules\Company\Repositories\Dashboard\DeliveryChargeRepository as DeliveryCharge;

class DeliveryChargeController extends Controller
{
    protected $company;
    protected $deliveryCharge;

    function __construct(DeliveryCharge $deliveryCharge, Company $company)
    {
        $this->company = $company;
        $this->deliveryCharge = $deliveryCharge;
    }

    public function index()
    {
        return view('company::dashboard.delivery-charges.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->company->QueryTable($request, [
            "deliveryCharge as delivery_charges"
        ]));

        $datatable['data'] = CompanyResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function edit($id)
    {
        $company = $this->company->findById($id);
        if (!$company)
            abort(404);

        $charges = $company->deliveryCharge()->pluck('delivery', 'state_id')->toArray();
        // $times = $company->deliveryCharge()->pluck('delivery_time', 'state_id')->toArray();
        $times = $company->deliveryCharge()->get(['delivery_time', 'state_id'])->toArray();
        $statuses = $company->deliveryCharge()->pluck('status', 'state_id')->toArray();
        $min_order_amounts = $company->deliveryCharge()->pluck('min_order_amount', 'state_id')->toArray();
        return view('company::dashboard.delivery-charges.edit', compact('company', 'charges', 'times', 'statuses', 'min_order_amounts'));
    }

    public function update(DeliveryChargeRequest $request, $companyId)
    {
        try {
            $company = $this->company->findById($companyId);
            $update = $this->deliveryCharge->update($request, $company);

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
