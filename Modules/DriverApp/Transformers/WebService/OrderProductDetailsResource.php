<?php

namespace Modules\DriverApp\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\WebService\CategoryDetailsResource;
use Modules\Catalog\Transformers\WebService\ProductImagesResource;

class OrderProductDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'sku' => $this->sku,
            'price' => $this->price,
            'qty' => $this->qty,
            'image' => url($this->image),
            'title' => $this->title,
            'description' => htmlView($this->description),
            'short_description' => $this->short_description,
//            'vendor_id' => $this->vendor_id,
            //            'new_arrival' => new ProductNewArrivalResource($this->whenLoaded('newArrival')),
            //            'offer' => new ProductOfferResource($this->whenLoaded('offer')),
            'images' => ProductImagesResource::collection($this->whenLoaded('images')),
//            'categories' => $this->categories->pluck('id'),

            'categories' => $this->parentCategories->pluck('id'),
            'sub_categories' => CategoryDetailsResource::collection($this->subCategories),

//            'products_options' => ProductOptionResource::collection($this->options),
            //            'variations_values' => ProductVariantResource::collection($this->variants),
        ];

        return $result;
    }
}
