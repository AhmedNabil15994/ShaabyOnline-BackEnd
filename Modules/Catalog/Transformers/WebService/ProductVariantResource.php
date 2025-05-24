<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'qty' => $this->qty,
            'sku' => $this->sku,
            'price' => $this->price,
            'image' => url($this->image),
            'dimensions' => $this->shipment,
            'offer' => $this->offer ? new ProductOfferResource($this->offer) : null,
            'variations' => ProductVariantValueResource::collection($this->productValues),
        ];
    }
}
