<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Http\Requests\Dashboard\PaymentRequest;
use Modules\Vendor\Transformers\Dashboard\PaymentResource;
use Modules\Vendor\Repositories\Dashboard\PaymentRepository as Payment;

class PaymentController extends Controller
{

    function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function index()
    {
        return view('vendor::dashboard.payments.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->payment->QueryTable($request));

        $datatable['data'] = PaymentResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('vendor::dashboard.payments.create');
    }

    public function store(PaymentRequest $request)
    {
        try {
            $create = $this->payment->create($request);

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
        return view('vendor::dashboard.payments.show');
    }

    public function edit($id)
    {
        $payment = $this->payment->findById($id);

        return view('vendor::dashboard.payments.edit',compact('payment'));
    }

    public function update(PaymentRequest $request, $id)
    {
        try {
            $update = $this->payment->update($request,$id);

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
            $delete = $this->payment->delete($id);

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
            $deleteSelected = $this->payment->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
