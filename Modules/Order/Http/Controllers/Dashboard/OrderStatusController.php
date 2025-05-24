<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Core\Traits\DataTable;
use Modules\Order\Http\Requests\Dashboard\OrderStatusRequest;
use Modules\Order\Transformers\Dashboard\OrderStatusResource;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;

class OrderStatusController extends Controller
{
    protected $orderStatus;

    function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    public function index()
    {
        return view('order::dashboard.order-statuses.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->orderStatus->QueryTable($request));
        $datatable['data'] = OrderStatusResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('order::dashboard.order-statuses.create');
    }

    public function store(OrderStatusRequest $request)
    {
        try {
            $newFlag = Str::slug($request->title['en'], '_');
            if (in_array($newFlag, ['pending', 'cancelled', 'refund', 'success', 'failed', 'delivered', 'new_order']))
                return Response()->json([false, __('order::dashboard.order_statuses.validation.title.unique')]);

            $request->request->add(['flag' => $newFlag]);
            $create = $this->orderStatus->create($request);

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
        return view('order::dashboard.order-statuses.show');
    }

    public function edit($id)
    {
        $orderStatus = $this->orderStatus->findById($id);
        if (!$orderStatus)
            abort(404);

        $orderStatus->color_label = !is_null($orderStatus->color_label) ? \GuzzleHttp\json_decode($orderStatus->color_label) : ['text' => 'info', 'value' => '#D1EBF1'];
        return view('order::dashboard.order-statuses.edit', compact('orderStatus'));
    }

    public function update(OrderStatusRequest $request, $id)
    {
        try {
            $update = $this->orderStatus->update($request, $id);

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
            $delete = $this->orderStatus->delete($id);

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
            $deleteSelected = $this->orderStatus->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
