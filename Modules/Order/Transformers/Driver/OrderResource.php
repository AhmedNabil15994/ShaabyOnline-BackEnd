<?php

namespace Modules\Order\Transformers\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
           'id'                   => $this->id,
           'total'                => $this->total,
           'shipping'             => $this->shipping,
           'subtotal'             => $this->subtotal,
           'transaction'          => $this->transactions->method,
           'deleted_at'           => $this->deleted_at,
           'created_at'           => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
