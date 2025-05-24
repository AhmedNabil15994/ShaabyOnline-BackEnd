<?php

namespace Modules\Report\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderRefundItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $item = $this->item;
        if ($item)
            $product = !is_null($this->item->variant) ? $this->item->variant->product : $this->item->product;
        else $product = null;

        return [
            "id" => $this->id,
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
            "qty" => $this->qty,
            "total" => $this->total,
            "type" => optional($this->item)->variant ? "variant" : "product",
            "title" => $product ? $product->title : "Deleted",
            "vendor_title" => $product ? $product->vendor->title : "Deleted",
            "order_id" => $item ? $this->item->order_id : "Deleted",
            "price" => $item ? ($this->item)->price : 0

        ];
    }
}
