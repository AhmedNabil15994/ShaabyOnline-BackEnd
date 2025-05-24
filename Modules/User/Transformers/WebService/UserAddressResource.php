<?php

namespace Modules\User\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            //            'civil_id' => intval($this->civil_id),
            //            'civil_id' => $this->civil_id,
            'email' => $this->email,
            'username' => $this->username,
            'mobile' => $this->mobile,
            'block' => $this->block,
            'street' => $this->street,
            'building' => $this->building,
            'state' => $this->state->title,
            'state_id' => intval($this->state_id),
            'avenue' => $this->avenue,
            'floor' => $this->floor,
            'flat' => $this->flat,
            'automated_number' => $this->automated_number,
            'additions' => $this->address,
            'is_default' => $this->is_default == 1,
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
