<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Traits\VendorTrait;
use Modules\Vendor\Transformers\WebService\DeliveryChargeResource;
use Modules\Vendor\Transformers\WebService\OpeningStatusResource;
use Modules\Vendor\Transformers\WebService\PaymenteResource;

class FilterVendorResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => url($this->image),
            'title' => $this->title,
            'description' => $this->description,
            'fixed_delivery' => $this->fixed_delivery,
            'order_limit' => $this->order_limit,
            'receive_question' => $this->receive_question,
            'receive_prescription' => $this->receive_prescription,
            'rate' => $this->getVendorTotalRate($this->rates),
            'opening_status' => new OpeningStatusResource($this->openingStatus),
        ];

        return $result;
    }
}
