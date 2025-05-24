<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource as Resource;

class VendorDeliveryChargeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'delivery_charges' => count($this->deliveryCharge),
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
