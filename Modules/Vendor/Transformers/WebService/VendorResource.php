<?php

namespace Modules\Vendor\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\WebService\PaginatedResource;
use Modules\Catalog\Transformers\WebService\ProductResource;
use Modules\Vendor\Traits\VendorTrait;

class VendorResource extends JsonResource
{
    use VendorTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => $this->image ? url($this->image) : null,
            'title' => $this->title,
            'description' => $this->description,
            // 'opening_status' => new OpeningStatusResource($this->openingStatus),
            'rate' => $this->getVendorRate($this->id),
            'address' => $this->address ?? null,
            'mobile' => !is_null($this->mobile) ? /*$this->calling_code .*/ $this->mobile : null,

            /*'payments' => PaymenteResource::collection($this->payments),
            'fixed_delivery' => $this->fixed_delivery,
            'order_limit' => $this->order_limit,
            'rate' => $this->getVendorTotalRate($this->rates),*/
        ];

        $result['opening_status'] = $this->checkVendorBusyStatus($this->id);

        if (request()->get('with_products') == 'yes') {
            $productsCount = request()->get('with_products_count') ?? 10;
            $result['products'] = ProductResource::collection($this->products->take($productsCount));
        }

        if (request()->route()->getName() == 'get_one_vendor') {
            $products = $request->products;
            $request->request->remove('products');
            $result['products'] = PaginatedResource::make($products)->mapInto(ProductResource::class);
        }


        /*if (request()->route()->getName() == 'get_one_vendor')
            $result['areas'] = (count($this->deliveryCharge) > 0) ? DeliveryChargeResource::collection($this->deliveryCharge) : null;
        else
            $result['delivery_charge'] = (count($this->deliveryCharge) > 0) ? new DeliveryChargeResource($this->deliveryCharge[0]) : null;*/

        return $result;
    }
}
