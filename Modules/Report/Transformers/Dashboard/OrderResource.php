<?php

namespace Modules\Report\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "qty" => $this->order_products_count + $this->order_variations_count,
            "vendors_count" => $this->vendors_count,
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
        ];
    }
}
