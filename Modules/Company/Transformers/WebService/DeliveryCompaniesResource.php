<?php

namespace Modules\Company\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Vendor\Traits\VendorTrait;
use Modules\Vendor\Transformers\WebService\DeliveryChargeResource;

class DeliveryCompaniesResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => url($this->image),
            'name' => $this->name,
            'manager_name' => $this->manager_name,
        ];

        $result['delivery_charge'] = (count($this->deliveryCharge) > 0) ? new DeliveryChargeResource($this->deliveryCharge[0]) : null;
        $result['availabilities'] = (count($this->availabilities) > 0) ? AvailabilitiesResource::collection($this->availabilities) : [];

        return $result;
    }
}
