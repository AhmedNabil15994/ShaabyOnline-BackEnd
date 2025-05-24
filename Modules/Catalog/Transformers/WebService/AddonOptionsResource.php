<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class AddonOptionsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->addonOption->id,
            'option' => $this->addonOption->getTranslation('title', locale()) ?? '---',
            'price' => number_format($this->addonOption->price, 3),
            'qty' => $this->addonOption->qty,
            'image' => !is_null($this->addonOption->image) ? url($this->addonOption->image) : null,
            'default' => $this->default ? 1 : 0,
        ];
    }
}
