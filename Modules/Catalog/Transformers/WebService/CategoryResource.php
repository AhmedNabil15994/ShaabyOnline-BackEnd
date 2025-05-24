<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Advertising\Transformers\WebService\AdvertisingResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image ? url($this->image) : null,
        ];

        if (request()->get('with_products') == 'yes') {
            $productsCount = request()->get('with_products_count') ?? 10;
            $result['products'] = ProductResource::collection($this->products->take($productsCount));
            $result['products_count'] = $this->products_count ?? 0;
        }
        if (request()->get('with_sub_categories') == 'yes') {
            $result['sub_categories'] = CategoryResource::collection($this->childrenRecursive);
        }

        $result['adverts'] = AdvertisingResource::collection($this->adverts);
        return $result;
    }
}
