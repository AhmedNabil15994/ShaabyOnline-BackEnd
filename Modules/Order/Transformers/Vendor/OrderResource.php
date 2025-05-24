<?php

namespace Modules\Order\Transformers\Vendor;

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
            'unread'               => $this->unread,
            'total'                => $this->total,
            'shipping'             => $this->shipping,
            'subtotal'             => $this->subtotal,
            'transaction'          => optional($this->transactions)->method,
            'state'                => optional(optional(optional($this->orderAddress)->state))->title,
            'order_status_id'      => optional($this->orderStatus)->title,
            'deleted_at'           => $this->deleted_at,
            'created_at'           => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
