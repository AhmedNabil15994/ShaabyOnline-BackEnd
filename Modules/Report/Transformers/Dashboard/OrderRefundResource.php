<?php

namespace Modules\Report\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderRefundResource extends JsonResource
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
            "id" => $this->id,
            'total' => $this->total,
            'shipping' => $this->shipping,
            'subtotal' => $this->subtotal,
            "transactions_id" => optional($this->transactions)->method ?? "---",
            "user_id" => optional($this->user)->name ?? "",
            "cashier_id" => optional($this->cashier)->name ?? "",
            "qty" => $this->variations_refund_qty + $this->products_refund_qty,
            "variations_refund_qty" => $this->variations_refund_qty,
            "products_refund_qty" => $this->products_refund_qty,
            "vendors_count" => $this->vendors_count,
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
        ];
    }
}
