<?php

namespace Modules\Order\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Transformers\Driver\OrderResource;
use Modules\Order\Repositories\Driver\OrderRepository as Order;

class OrderController extends Controller
{

    function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        return view('order::driver.orders.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        $order = $this->order->findById($id);

        return view('order::driver.orders.show',compact('order'));
    }
}
