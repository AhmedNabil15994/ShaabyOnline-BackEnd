<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOfferResource extends JsonResource
{
    public function toArray($request)
    {
        if (!is_null($this->offer_price)) {
            $result['type'] = 'amount';
            $result['offer_price'] = $this->offer_price;
            $result['percentage'] = number_format(calculateOfferPercentageByAmount($this->product->price, $this->offer_price), 3);
        } else {
            $result['type'] = 'percentage';
            $result['offer_price'] = number_format(calculateOfferAmountByPercentage($this->product->price, $this->percentage), 3);
            $result['percentage'] = $this->percentage;
        }
        return $result;

        /*$result = [
            'offer_price' => $this->offer_price,
            'percentage' => $this->percentage,
        ];
        if ($this->product)
            $result['offer_percentage_price'] = (floatval($this->offer_price) / floatval($this->product->price)) * 100;
        else
            $result['offer_percentage_price'] = null;

        return $result;*/
    }
}
