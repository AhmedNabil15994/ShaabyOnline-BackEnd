<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorStatusResource extends JsonResource
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
           'id'               => $this->id,
           'accepted_orders'  => $this->accepted_orders,
           'title'            => $this->title,
           'label_color'      => $this->label_color,
           'deleted_at'       => $this->deleted_at,
           'created_at'       => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
