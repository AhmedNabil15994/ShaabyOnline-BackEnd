<?php

namespace Modules\Cart\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Entities\Product;
use Modules\Variation\Entities\ProductVariant;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => (string) $this->id,
            'qty' => $this->quantity,
            'image' => url($this->attributes->product->image),
            'product_type' => $this->attributes->product->product_type,
            'notes' => $this->attributes->notes,
        ];

        if ($this->attributes->product->product_type == 'product') {
            $result['product_id'] = $this->attributes->product->id;
            $result['title'] = $this->attributes->product->title;
            $currentProduct = Product::find($this->attributes->product->id);
            // $result['remaining_qty'] = intval($currentProduct->qty) - intval($this->quantity);
        } else {
            $result['product_id'] = $this->attributes->product->product->id;
            $result['title'] = $this->attributes->product->product->title;
            $result['product_options'] = CartProductOptionsResource::collection($this->attributes->product->productValues);
            $currentProduct = ProductVariant::find($this->attributes->product->id);
            // $result['remaining_qty'] = intval($currentProduct->qty) - intval($this->quantity);
        }

        if ($currentProduct) {
            if (!is_null($currentProduct->qty)) {
                $result['remaining_qty'] = intval($currentProduct->qty);
            } else {
                $result['remaining_qty'] = null;
            }
        } else {
            $result['remaining_qty'] = 0;
        }

        if ($this->attributes->addonsOptions) {
            $price = floatval($this->price) - floatval($this->attributes->addonsOptions['total_amount']);
            $result['price'] = number_format($price, 3);
        } else {
            $result['price'] = number_format($this->price, 3);
        }

        $result['addons'] = $this->attributes->addonsOptions;
        $result['offer'] = $this->buildProductOffer($this->attributes->product);

        return $result;
    }

    private function buildProductOffer($product)
    {
        $offerDetails = null;
        if (!is_null($product->offer)) {
            $offerDetails['original_price'] = $product->price;
            if (!is_null($product->offer->offer_price)) {
                $offerDetails['type'] = 'amount';
                $offerDetails['offer_price'] = $product->offer->offer_price;
                $offerDetails['percentage'] = number_format(calculateOfferPercentageByAmount($product->price, $product->offer->offer_price), 3);
            } else {
                $offerDetails['type'] = 'percentage';
                $offerDetails['offer_price'] = number_format(calculateOfferAmountByPercentage($product->price, $product->offer->percentage), 3);
                $offerDetails['percentage'] = $product->offer->percentage;
            }
        } else {
            $offerDetails = null;
        }

        return $offerDetails;
    }
}
