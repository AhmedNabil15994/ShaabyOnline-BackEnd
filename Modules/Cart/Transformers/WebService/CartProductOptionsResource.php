<?php

namespace Modules\Cart\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\WebService\ProductOptionResource;
use Modules\Catalog\Transformers\WebService\ProductVariantResource;
use Modules\Catalog\Transformers\WebService\ProductVariantValueResource;

class CartProductOptionsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->productOption->option->id,
            'title' => $this->productOption->option->title,
            'option_value' => new CartProductOptionValuesResource($this->optionValue),
        ];
    }
}
