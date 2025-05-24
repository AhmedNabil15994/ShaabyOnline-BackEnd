<?php

namespace Modules\Order\ViewComposers\Dashboard;

use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;
use Illuminate\View\View;

class OrderStatusComposer
{
    public $orderStatuses = [];

    public function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatuses =  $orderStatus->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('orderStatuses', $this->orderStatuses);
    }
}
