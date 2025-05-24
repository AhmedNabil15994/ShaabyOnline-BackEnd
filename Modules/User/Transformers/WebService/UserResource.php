<?php

namespace Modules\User\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Traits\AreaTrait;

class UserResource extends JsonResource
{
    use AreaTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'calling_code' => $this->calling_code,
            'mobile' => $this->mobile,
            'image' => url($this->image),
            "is_verified" => $this->is_verified,
            "firebase_uuid" => $this->firebase_uuid,
            "code_verified" => $this->code_verified,
        ];

        if (!is_null($this->country)) {
            $result['country'] = $this->getCountryInfoByCode($this->country);
        } else {
            $result['country'] = null;
        }

        $result['addresses'] = UserAddressResource::collection($this->addresses);

        return $result;
    }
}
