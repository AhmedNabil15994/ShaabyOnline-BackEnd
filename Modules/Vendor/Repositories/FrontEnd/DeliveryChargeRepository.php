<?php

namespace Modules\Vendor\Repositories\FrontEnd;

use Modules\Vendor\Entities\DeliveryCharge;
use Hash;
use DB;

class DeliveryChargeRepository
{

    function __construct(DeliveryCharge $deliveryCharge)
    {
        $this->deliveryCharge   = $deliveryCharge;
    }


    public function getAll($order = 'id', $sort = 'desc')
    {
        $deliveryCharges = $this->deliveryCharge->orderBy($order, $sort)->get();
        return $deliveryCharges;
    }

    public function findById($id)
    {
        $deliveryCharge = $this->deliveryCharge->find($id);
        return $deliveryCharge;
    }

    public function findDeliveryCharge($vendorId,$stateId)
    {
        $deliveryCharge = $this->deliveryCharge
                          ->where('vendor_id',$vendorId)
                          ->where('state_id',$stateId)
                          ->first();

        return $deliveryCharge;
    }
}
