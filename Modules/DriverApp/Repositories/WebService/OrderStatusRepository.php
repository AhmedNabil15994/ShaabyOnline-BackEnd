<?php

namespace Modules\DriverApp\Repositories\WebService;

use Modules\Order\Entities\OrderStatus;
use Illuminate\Support\Facades\DB;

class OrderStatusRepository
{
    protected $orderStatus;

    function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $query = $this->orderStatus->where('flag', '!=', 'failed');
        if (auth('api')->user()->can('driver_access')) {
            $query = $query->whereIn('flag', ['new_order', 'delivered', 'received']);
        }
        return $query->orderBy($order, $sort)->get();
    }

    public function getAllFinalStatus($order = 'id', $sort = 'desc')
    {
        return $this->orderStatus->finalStatus()->orderBy($order, $sort)->get();
    }
}
