<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Advertising\Transformers\WebService\AdvertisingResource;
use Modules\Tags\Transformers\WebService\TagsResource;
use Modules\Vendor\Traits\VendorTrait;

class ProductResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'sku' => $this->sku,
            'origin_price' => $this->origin_price,
            'qty' => $this->qty,
            'is_new' => $this->is_new == 1,
            'image' => url($this->image),
            'title' => optional($this)->title,
            'description' => htmlView(optional($this)->description),
            'short_description' => optional($this)->short_description,
            'dimensions' => $this->shipment,
            'offer' => new ProductOfferResource($this->offer),
            'images' => ProductImagesResource::collection($this->images),
            'tags' => TagsResource::collection($this->tags),
            'products_options' => ProductOptionResource::collection($this->options),
            'variations_values' => ProductVariantResource::collection($this->variants),

            'addons' => AddOnsResource::collection($this->addOns),
            'adverts' => AdvertisingResource::collection($this->adverts),
            'sharable_link' => route('frontend.products.index', $this->slug),

            //'categories' => $this->parentCategories->pluck('id'),
            //'sub_categories' => CategoryDetailsResource::collection($this->subCategories),
        ];

        if ($this->variants->count() > 0) {
            $result['price'] = $this->variants->first()->price;
        } else {
            $result['price'] = $this->price;
        }

        if ($this->vendor) {
            $result['vendor'] = [
                'id' => $this->vendor->id,
                'title' => optional($this->vendor)->title,
                'image' => $this->vendor->image ? url($this->vendor->image) : null,
                'opening_status' => $this->checkVendorBusyStatus($this->vendor->id),
            ];
        } else {
            $result['vendor'] = null;
        }

        if (auth('api')->check()) {
            $result['is_favorite'] = CheckProductInUserFavourites($this->id, auth('api')->id());
        } else {
            $result['is_favorite'] = null;
        }

        return $result;
    }
}
