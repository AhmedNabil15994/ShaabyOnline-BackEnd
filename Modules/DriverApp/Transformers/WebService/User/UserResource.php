<?php

namespace Modules\DriverApp\Transformers\WebService\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'image' => $this->image ? url($this->image) : null,
            'roles' => array_column($this->roles->toArray(), 'name'),
        ];
    }
}
