<?php

namespace Modules\Company\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryChargeResource extends JsonResource
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
            'company' => $this->name,
            'state' => $this->description,
            'delivery' => $this->delivery,
            'delivery_time' => $this->delivery_time,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
