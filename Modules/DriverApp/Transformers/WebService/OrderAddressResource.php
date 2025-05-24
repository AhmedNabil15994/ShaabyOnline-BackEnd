<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderAddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'username' => $this->username,
            'state_id' => $this->state_id,
            'state' => optional($this->state)->title,
            'city' => optional(optional($this->state)->city)->title,
            'block' => $this->block,
            'building' => $this->building,
            'street' => $this->street,
            'address' => $this->address,
        ];
    }
}
