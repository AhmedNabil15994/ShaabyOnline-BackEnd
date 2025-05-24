<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDriverResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'accepted' => $this->accepted,
            'delivered' => $this->delivered,
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
            'user' => new DriverUserResource($this->user),
        ];
    }
}
