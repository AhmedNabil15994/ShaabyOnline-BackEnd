<?php

namespace Modules\Order\Repositories\WebService;

use Modules\Order\Entities\OrderStatus;
use Hash;
use DB;

class OrderStatusRepository
{

    function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus   = $orderStatus;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orderStatuses = $this->orderStatus->orderBy($order, $sort)->get();
        return $orderStatuses;
    }

    public function getAllFinalStatus($order = 'id', $sort = 'desc')
    {
        $orderStatuses = $this->orderStatus->finalStatus()->orderBy($order, $sort)->get();
        return $orderStatuses;
    }
}
