<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class AddOnsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->addonCategory->id,
            'name' => $this->addonCategory->getTranslation('title', locale()) ?? '---',
            'image' => !is_null($this->addonCategory->image) ? url($this->addonCategory->image) : null,
            'type' => $this->type,
            'min_options_count' => $this->min_options_count ?? null,
            'max_options_count' => $this->max_options_count ?? null,
            'is_required' => $this->is_required == 1,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
            'addonOptions' => AddonOptionsResource::collection($this->addonOptions),
        ];
    }
}
