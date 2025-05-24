<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class FilterProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => is_null($this->price) ? 0 : $this->price,
            'qty' => is_null($this->qty) ? 0 : $this->qty,
            'offer' => new ProductOfferResource($this->whenLoaded('offer')),
            'image' => url($this->mainProduct->image),
            'title' => $this->mainProduct->title,
            'description' => htmlView($this->mainProduct->description),
            'short_description' => $this->mainProduct->short_description,
            'vendor' => new FilterVendorResource($this->vendor),
        ];
    }
}
