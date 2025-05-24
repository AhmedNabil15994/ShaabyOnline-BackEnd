<?php

namespace Modules\Report\ViewComposers\Vendor;

use Modules\Order\Repositories\Vendor\OrderRepository as Order;
use Illuminate\View\View;

class OrderComposer
{
    protected $orders;
    protected $ordersType;
    protected $monthlyOrders;
    protected $totalProfit;
    protected $todayProfit;
    protected $monthProfit;
    protected $yearProfit;
    protected $totalProfitCommission;

    public function __construct(Order $order)
    {
        $this->orders = $order->completeOrders();
        $this->monthlyOrders = $order->monthlyOrders();
        $this->ordersType = $order->ordersType();
        $this->totalProfit = $order->totalProfit();
        $this->todayProfit = $order->totalTodayProfit();
        $this->monthProfit = $order->totalMonthProfit();
        $this->yearProfit = $order->totalYearProfit();
        $this->totalProfitCommission = $order->totalProfitCommission();
    }

    public function compose(View $view)
    {
        $view->with('monthlyOrders', $this->monthlyOrders);
        $view->with('completeOrders', $this->orders);
        $view->with('totalProfit', $this->totalProfit);
        $view->with('ordersType', $this->ordersType);
        $view->with([
            "todayProfit" => $this->todayProfit,
            "monthProfit" => $this->monthProfit,
            "yearProfit" => $this->yearProfit,
            "totalProfitCommission" => $this->totalProfitCommission,
        ]);
    }
}
