<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
//            'id' => $this->id,
            'selling_price' => $this->price,
            'qty' => $this->qty,
            'total' => $this->total,
        ];

        if (isset($this->product_variant_id) && !empty($this->product_variant_id)) {
            $result['title'] = optional(optional($this->variant)->product)->title;
            $result['image'] = url(optional($this->variant)->image);
            $result['sku'] = optional($this->variant)->sku;
//            $result['product_details'] = new ProductResource($this->variant->product);
        } else {
            $result['title'] = optional($this->product)->title;
            $result['image'] = url(optional($this->product)->image);
            $result['sku'] = optional($this->product)->sku;
//            $result['product_details'] = new ProductResource($this->product);
        }

        return $result;
    }
}
