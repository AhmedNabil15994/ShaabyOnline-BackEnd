<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => url($this->image),
            'color' => $this->color,
            'sub_categories' => CategoryDetailsResource::collection($this->subCategories),
//            'products' => ProductResource::collection($this->products)
//           'products'      => ProductOfCategoryResource::collection($this->products)
        ];
    }
}
