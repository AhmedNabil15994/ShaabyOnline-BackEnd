<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'image' => url($this->image),
            'products_count' => $this->products_count,
        ];
        return $result;
    }
}
