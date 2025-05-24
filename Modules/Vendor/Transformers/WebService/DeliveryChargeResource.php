<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryChargeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
//           'state_id'      => $this->state_id,
            'delivery_price' => $this->delivery,
            'delivery_time' => $this->delivery_time,
        ];
    }
}
