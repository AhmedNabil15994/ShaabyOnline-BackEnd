<?php

namespace Modules\Order\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;
use Modules\Catalog\Entities\Product;
use Modules\Variation\Entities\ProductVariant;

trait OrderCalculationTrait
{
    public function calculateTheOrder($userToken = null)
    {
        $total = $this->totalOrder($userToken);
        $order = $this->orderProducts($userToken);
        $order['subtotal'] = $this->subTotalOrder($userToken);
        $order['shipping'] = $this->getOrderShipping($userToken);
        $order['shipping_details'] = getCartConditionByName($userToken, 'company_delivery_fees')->getAttributes() ?? [];
        $order['total'] = $total;

        $productsCollection = collect($order["products"]);
        $productsCollection = $productsCollection->groupBy("vendor_id");

        if (!is_null(getCartConditionByName($userToken, 'coupon_discount'))) {
            $couponCondition = getCartConditionByName($userToken, 'coupon_discount');
            $order['coupon']['id'] = $couponCondition->getAttributes()['coupon']->id;
            $order['coupon']['code'] = $couponCondition->getAttributes()['coupon']->code;
            $order['coupon']['type'] = $couponCondition->getAttributes()['coupon']->discount_type;
            $order['coupon']['discount_value'] = $couponCondition->getAttributes()['coupon']->discount_value ?? $couponCondition->getValue();
            $order['coupon']['discount_percentage'] = $couponCondition->getAttributes()['coupon']->discount_percentage;
            $order['coupon']['products'] = $order['couponProducts'];
        } else {
            $order['coupon'] = null;
        }

        foreach ($order['vendors'] as $k => $vendor) {
            $vendorItems = $productsCollection->get($vendor->id);
            $totalQty = $vendorItems->sum("quantity");
            $total = $vendorItems->sum("total");

            $order['vendors'][$k]['id'] = $vendor->id;
            /*$order['vendors'][$k]['commission'] = $this->commissionFromVendor($vendor, $total);
            $order['vendors'][$k]['totalProfitCommission'] = floatval($order['vendors'][$k]['commission']) + floatval($order['profit']);*/
            $order["vendors"][$k]["original_subtotal"] = $total;
            $order["vendors"][$k]["subtotal"] = $this->calcDiscountForTotal($total, $userToken);
            $order["vendors"][$k]["qty"] = $totalQty;
        }

        return $order;
    }

    public function totalOrder($userToken = null)
    {
        return getCartTotal($userToken);
    }

    public function subTotalOrder($userToken = null)
    {
        return getCartSubTotal($userToken);
    }

    public function getOrderShipping($userToken = null)
    {
        return getOrderShipping($userToken);
    }

    public function commissionFromVendor($vendor, $total)
    {
        $percentege = $vendor['commission'] ? $total * ($vendor['commission'] / 100) : 0.000;
        $fixed = $vendor['fixed_commission'] ? $vendor['fixed_commission'] : 0.000;

        return $percentege + $fixed;
    }

    public function orderProducts($userToken = null)
    {
        $data = [];
        $subtotal = 0.000;
        $off = 0.000;
        $price = 0.000;
        $profite = 0.000;
        $profitePrice = 0.000;
        $vendors = [];
        $couponProducts = [];

        foreach (getCartContent($userToken) as $k => $value) {

            $vendorsIDs = array_column($vendors, 'id');

            if ($value->attributes->product_type == 'product') {
                $vendor = $value->attributes->product->vendor;
                $product['product_type'] = 'product';
                $product['vendor_id'] = $vendor->id;
                $offerColumnName = 'product_id';
                // Get updated product from db.
                $productObject = Product::with(['offer' => function ($query) {
                    $query->active()->unexpired()->started();
                }])->find($value->attributes->product->id);

                if (count($value->conditions) > 0)
                    $couponProducts[] = $value->attributes->product->id;
            } else {
                $vendor = $value->attributes->product->product->vendor;
                $product['product_type'] = 'variation';
                $product['vendor_id'] = $vendor->id;
                $product['selectedOptions'] = $value->attributes->selectedOptions;
                $product['selectedOptionsValue'] = $value->attributes->selectedOptionsValue;
                $offerColumnName = 'product_variant_id';
                $productObject = ProductVariant::with([
                    'offer' => function ($query) {
                        $query->active()->unexpired()->started();
                    },
                    'productValues', 'product',
                ])->active()->find($value->attributes->product->id);

                if (count($value->conditions) > 0)
                    $couponProducts[] = $value->attributes->product->product->id;
            }

            if (!in_array($vendor ? $vendor->id : null, $vendorsIDs)) {
                $vendors[] = $vendor;
            }

            $product['product_id'] = $value->attributes->product->id;
            $product['product'] = $value->attributes->product;

            $offerPrice = 0;
            // Check Product Offer
            if (!is_null($productObject) && $productObject->offer()->exists()) {
                // $offerPrice = $value->attributes->product->offer->where($offerColumnName, $value->attributes->product->id)->active()->unexpired()->value('offer_price');

                $offerPercentagePrice = $productObject->offer()->where($offerColumnName, $value->attributes->product->id)->active()->unexpired()->value('percentage');
                $offerAmountPrice = $productObject->offer()->where($offerColumnName, $value->attributes->product->id)->active()->unexpired()->value('offer_price');
                if (!is_null($offerPercentagePrice) && is_null($offerAmountPrice)) { // Percentage value exists
                    $percentageResult = (floatval($productObject->price) * floatVal($offerPercentagePrice)) / 100;
                    $offerPrice = floatval($productObject->price) - $percentageResult;
                } elseif (is_null($offerPercentagePrice) && !is_null($offerAmountPrice)) { // Amount value exists
                    $offerPrice = $offerAmountPrice;
                } else {
                    $offerPrice = $productObject->price;
                }
            } else {
                $offerPrice = $productObject->price;
            }

            $product['original_price'] = $offerPrice;

            $product['sku'] = $value->attributes->product->sku;
            $product['quantity'] = $value->quantity;

            $product['sale_price'] = $offerPrice;

            $product['off'] = $product['original_price'] - $product['sale_price'];
            $product['original_total'] = $product['original_price'] * $product['quantity'];
            $product['total'] = $product['sale_price'] * $product['quantity'];
            $product['cost_price'] = $offerPrice; /*$value->attributes->product->cost_price*/
            $product['total_cost_price'] = $product['cost_price'] * $product['quantity'];
            $product['total_profit'] = $product['total'] - $product['total_cost_price'];

            $off += $product['off'];
            $price += $product['total'];
            $subtotal += $product['original_total'];
            $profitePrice += $product['total_cost_price'];
            $profite += $product['total_profit'];
            $product['notes'] = $value->attributes->notes ?? null;
            $product['addonsOptions'] = $value->attributes->addonsOptions ?? [];

            $data[] = $product;
        }

        return [
            'profit' => $profite,
            'off' => $off,
            'original_subtotal' => $subtotal,
            'products' => $data,
            'vendors' => $vendors,
            'couponProducts' => $couponProducts,
        ];
    }

    public function calcDiscountForTotal($total, $userToken)
    {
        $subtotal = $total;
        $coupon = getCartConditionByName($userToken, "coupon_discount");
        if ($coupon) {
            $couponModel = $coupon->getAttributes()["coupon"];
            if ($couponModel) {
                $discount = $coupon->getCalculatedValue($total);
                $discount = $couponModel->max_discount_percentage_value > 0 && $couponModel->max_discount_percentage_value < $discount ? $couponModel->max_discount_percentage_value : $discount;
                $subtotal -= $discount;
            }
        }
        return $subtotal;
    }
}
