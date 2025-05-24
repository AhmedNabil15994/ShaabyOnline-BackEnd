<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationsResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'price' => $this->price,
            'qty' => $this->qty,
            'sku' => $this->sku,
            'image' => url($this->image),
            'offer' => new VariationOfferResource($this->offer->active()->unexpired()->first()),
            'productValues' => ProductVariationValuesResource::collection($this->productValues),

//            'productValues' => $this->productValues,
//            'title' => $this->title,
//            'offer' => new ProductOfferResource($this->whenLoaded('offer')),

        ];
        return $result;
    }
}
