<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class FilteredOptionValuesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'option_value' => $this->title,
        ];
    }
}
