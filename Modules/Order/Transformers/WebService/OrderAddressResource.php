<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderAddressResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'username' => $this->username,
            'state_id' => $this->state_id,
            'state' => $this->state->title,
            'block' => $this->block,
            'building' => $this->building,
            'street' => $this->street,
            'avenue' => $this->avenue,
            'floor' => $this->floor,
            'flat' => $this->flat,
            'automated_number' => $this->automated_number,
            'additions' => $this->address,
        ];

        if (is_null($this->state->city)) {
            $result['city'] = null;
        } else {
            $result['city'] = [
                'id' => $this->state->city->id,
                'title' => $this->state->city->title,
            ];
        }

        if (is_null($this->state->city) || is_null($this->state->city->country)) {
            $result['country'] = null;
        } else {
            $result['country'] = [
                'id' => $this->state->city->country->id,
                'title' => $this->state->city->country->title,
            ];
        }

        return $result;
    }
}
