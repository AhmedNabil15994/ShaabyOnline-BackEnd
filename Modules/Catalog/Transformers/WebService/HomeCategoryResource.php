<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\WebService\ProductResource;

class HomeCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => url($this->image ?? "/uploads/default.png"),
            "products" => $this->when($request->with_products, function () use ($request) {
                $productsCount = $request->get('with_products_count') ?? 10;
                return ProductResource::collection(
                    $this->products()
                        ->active()
                        ->when($request->state_id, function ($query) use ($request) {
                            if (config('setting.other.select_shipping_provider') == 'shipping_company')
                                $query->whereHas("vendor.companies.deliveryCharge", fn ($q) => $q->active()->filterState($request->state_id));
                            elseif (config('setting.other.select_shipping_provider') == 'vendor_delivery')
                                $query->whereHas("vendor.deliveryCharge", fn ($q) => $q->active()->filterState($request->state_id));
                        })
                        ->limit($productsCount)
                        ->get()
                );
            }),
            "products_count" => $this->when($request->with_products, function () use ($request) {
                $this->loadCount([
                    "products" => function ($q) use ($request) {
                        $q->active()
                            ->when($request->state_id, function ($query) use ($request) {
                                if (config('setting.other.select_shipping_provider') == 'shipping_company')
                                    $query->whereHas("vendor.companies.deliveryCharge", fn ($q) => $q->active()->filterState($request->state_id));
                                elseif (config('setting.other.select_shipping_provider') == 'vendor_delivery')
                                    $query->whereHas("vendor.deliveryCharge", fn ($q) => $q->active()->filterState($request->state_id));
                            });
                    }
                ]);

                return $this->products_count ?? 0;
            }),
            'adverts' => [],
        ];
    }
}
