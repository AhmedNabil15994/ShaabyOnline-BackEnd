<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationOfferResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id' => $this->id,
           'offer_price' => $this->offer_price,
       ];
    }
}
