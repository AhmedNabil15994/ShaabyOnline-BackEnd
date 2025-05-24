<?php

namespace Modules\Cart\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class CartVendorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image ? url($this->image) : null,
            'title' => $this->title,
        ];
    }
}
