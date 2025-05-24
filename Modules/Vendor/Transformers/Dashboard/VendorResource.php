<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            // 'delivery_charges'   => count($this->deliveryCharge),
            'title'              => $this->title,
            'description'        => $this->description,
            'image'              => $this->image ? url($this->image) : null,
            'status'             => $this->status,
            'deleted_at'         => $this->deleted_at,
            'created_at'         => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
