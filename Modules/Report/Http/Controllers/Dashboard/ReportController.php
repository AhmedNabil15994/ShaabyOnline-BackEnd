<?php

namespace Modules\Report\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Report\Repositories\Dashboard\ReportRepository as Repo;

//use Modules\Report\Transformers\Dashboard\OrderRefundResource;
//use Modules\Report\Transformers\Dashboard\OrderRefundItemResource;
//use Modules\Report\Report\Transformers\Report\OrderResource;

class ReportController extends Controller
{
    protected $repo;

    function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function productsSale(Request $request)
    {
        return view('report::dashboard.reports.product-sales');
    }

    public function ordersSale(Request $request)
    {
        return view('report::dashboard.reports.order-sales');
    }

    public function productStock(Request $request)
    {
        return view('report::dashboard.reports.product-stock');
    }

    public function vendorTotal(Request $request)
    {
        return view('report::dashboard.reports.vendors');
    }

    public function vendorTotalDataTable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repo->vendors($request));
//        $datatable['data'] = $datatable['data'];
        return Response()->json($datatable);
    }

    public function productStockDataTable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repo->productStock($request));
//        $datatable['data'] = $datatable['data'];
        return Response()->json($datatable);
    }

    public function productsSaleDataTable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repo->productSales($request));
//        $datatable['data'] = $datatable['data'];
        return Response()->json($datatable);
    }

    public function ordersSaleDataTable(Request $request)
    {
        // $datatable = DataTable::drawTable($request, $this->repo->orderSales($request));
        // $datatable['data'] = OrderResource::collection($datatable['data']);
        $datatable = DataTable::drawTable($request, $this->repo->orderSalesSql($request));
//        $datatable['data'] = ($datatable['data']);
        return Response()->json($datatable);
    }

    /*public function refundSale(Request $request)
    {
        return view('report::dashboard.reports.refund');
    }

    public function refundOrders(Request $request)
    {
        return view('report::dashboard.reports.order-refund');
    }*/

    /*public function refundSaleDataTable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repo->refundSales($request));
        $datatable['data'] = OrderRefundItemResource::collection($datatable['data']);
        // $datatable = DataTable::drawTable($request, $this->repo->productRefunSql($request));
        // $datatable['data'] =OrderRefundItemResource::collection( $datatable['data'] );
        return Response()->json($datatable);
    }

    public function ordersRefundDataTable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repo->orderRefund($request));
        $datatable['data'] = OrderRefundResource::collection($datatable['data']);
        return Response()->json($datatable);
    }*/

}
