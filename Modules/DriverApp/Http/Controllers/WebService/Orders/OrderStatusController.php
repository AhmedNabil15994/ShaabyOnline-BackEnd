<?php

namespace Modules\DriverApp\Http\Controllers\WebService\Orders;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\DriverApp\Transformers\WebService\OrderStatusResource;
use Modules\DriverApp\Repositories\WebService\OrderStatusRepository as OrderStatus;

class OrderStatusController extends WebServiceController
{
    protected $status;

    function __construct(OrderStatus $status)
    {
        $this->status = $status;
    }

    public function index(Request $request)
    {
        $statuses = $this->status->getAll('sort', 'asc');
        return $this->response(OrderStatusResource::collection($statuses));
    }

}
