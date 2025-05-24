<?php

namespace Modules\Coupon\Http\Controllers\FrontEnd;

use Carbon\Carbon;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\FrontEnd\CouponRequest;

class CouponController extends Controller
{
    use ShoppingCartTrait;

    public function checkCouponOld(CouponRequest $request)
    {
        if (auth()->check())
            $userToken = auth()->user()->id ?? null;
        else
            $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;

        if (is_null($userToken))
            return response()->json(["errors" => __('apps::frontend.general.user_token_not_found')], 422);

        $coupon = Coupon::where('code', $request->code)->active()->first();
        if ($coupon) {
            if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d'))
                return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.expired')], 422);

            // Check if coupon is used before by this user
            $couponCondition = getCartConditionByName($userToken, 'coupon_discount');

            if (!is_null($couponCondition))
                return response()->json(["errors" => __('coupon::frontend.coupons.validation.coupon_is_used')], 422);

            $discount_value = 0;
            if ($coupon->discount_type == "value")
                $discount_value = $coupon->discount_value;
            elseif ($coupon->discount_type == "percentage") {
                $discount_percentage_value = (getCartSubTotal($userToken) * $coupon->discount_percentage) / 100;

                if ($discount_percentage_value > $coupon->max_discount_percentage_value)
                    $discount_value = $coupon->max_discount_percentage_value;
                else
                    $discount_value = $discount_percentage_value;
            }

            // $subTotal = getCartSubTotal($userToken) - $discount_value;
            // Save Coupon Discount Condition
            $resultCheck = $this->discountCouponCondition($coupon, $discount_value, $userToken);
            if (!$resultCheck)
                return response()->json(["errors" => __('coupon::frontend.coupons.validation.condition_error')], 422);

            $data = [
                "coupon_value" => number_format($discount_value, 3),
                "sub_total" => number_format(getCartSubTotal(), 3),
                "total" => number_format(getCartTotal(), 3),
            ];
            return response()->json(["message" => __('coupon::frontend.coupons.checked_successfully'), "data" => $data], 200);
        } else {
            return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.not_found')], 422);
        }
    }

    /*
     *** Start - Check Frontend Coupon
     */
    public function checkCoupon(CouponRequest $request)
    {
        if (auth()->check())
            $userToken = auth()->user()->id ?? null;
        else
            $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;

        if (is_null($userToken))
            return response()->json(["errors" => __('apps::frontend.general.user_token_not_found')], 422);

        $coupon = Coupon::where('code', $request->code)
            ->where('start_at', '<=', date('Y-m-d'))
            ->where('expired_at', '>', date('Y-m-d'))
            ->active()
            ->first();

        // Check if coupon is used before by this user
        /*$couponCondition = getCartConditionByName($userToken, 'coupon_discount');
        if (!is_null($couponCondition))
                     return response()->json(["errors" => __('coupon::frontend.coupons.validation.coupon_is_used')], 422);*/

        if ($coupon) {
            $coupon_users = $coupon->users->pluck('id')->toArray() ?? [];
            if ($coupon_users <> []) {
                if (auth()->check() && !in_array(auth()->id(), $coupon_users))
                    return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.custom')], 422);
            }

            // Remove Old General Coupon Condition
            $this->removeCartConditionByType('coupon_discount', $userToken);

            $cartItems = getCartContent($userToken);
            $prdList = $this->getProductsList($coupon, $coupon->flag);
            $prdListIds = array_values(!empty($prdList) ? array_column($prdList->toArray(), 'id') : []);
            $conditionValue = $this->addProductCouponCondition($cartItems, $coupon, $userToken, $prdListIds);
            $data = [
                "coupon_value" => $conditionValue > 0 ? number_format($conditionValue, 3) : 0,
                "sub_total" => number_format(getCartSubTotal(), 3),
                "total" => number_format(getCartTotal(), 3),
            ];

            /*if (!is_null($coupon->flag)) {
                $prdList = $this->getProductsList($coupon, $coupon->flag);
                $prdListIds = array_values(!empty($prdList) ? array_column($prdList->toArray(), 'id') : []);
                $conditionValue = $this->addProductCouponCondition($cartItems, $coupon, $userToken, $prdListIds);
                $data = [
                    "coupon_value" => $conditionValue > 0 ? number_format($conditionValue, 3) : 0,
                    "sub_total" => number_format(getCartSubTotal(), 3),
                    "total" => number_format(getCartTotal(), 3),
                ];
            } else {
                $discount_value = 0;
                if ($coupon->discount_type == "value")
                    $discount_value = $coupon->discount_value;
                elseif ($coupon->discount_type == "percentage")
                    $discount_value = (getCartSubTotal($userToken) * $coupon->discount_percentage) / 100;

                $this->addProductCouponCondition($cartItems, $coupon, $userToken, []);
                // Apply Coupon Discount Condition On All Products In Cart
                $resultCheck = $this->discountCouponCondition($coupon, $discount_value, $userToken);
                if (!$resultCheck)
                    return response()->json(["errors" => __('coupon::frontend.coupons.validation.condition_error')], 422);

                $data = [
                    "coupon_value" => number_format($discount_value, 3),
                    "sub_total" => number_format(getCartSubTotal(), 3),
                    "total" => number_format(getCartTotal(), 3),
                ];
            }*/

            return response()->json(["message" => __('coupon::frontend.coupons.checked_successfully'), "data" => $data], 200);
        } else {
            return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.not_found')], 422);
        }
    }

    protected function getProductsList($coupon, $flag = 'products')
    {
        $coupon_vendors = $coupon->vendors ? $coupon->vendors->pluck('id')->toArray() : [];
        $coupon_products = $coupon->products ? $coupon->products->pluck('id')->toArray() : [];
        $coupon_categories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];

        $products = Product::where('status', true);

        if ($flag == 'products') {
            $products = $products->whereIn('id', $coupon_products);
        }

        if ($flag == 'vendors') {
            $products = $products->whereHas('vendor', function ($query) use ($coupon_vendors, $flag) {
                $query->whereIn('id', $coupon_vendors);
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            });
        }

        if ($flag == 'categories') {
            $products = $products->whereHas('categories', function ($query) use ($coupon_categories) {
                $query->active();
                $query->whereIn('product_categories.category_id', $coupon_categories);
            });
        }

        return $products->get(['id']);
    }

    private function addProductCouponCondition($cartItems, $coupon, $userToken, $prdListIds = [])
    {
        $totalValue = 0;
        $discount_value = 0;

        foreach ($cartItems as $cartItem) {

            if ($cartItem->attributes->product->product_type == 'product') {
                $prdId = $cartKey = $cartItem->id;
            } else {
                $prdId = $cartItem->attributes->product->product->id;
                $cartKey = $cartItem->id;
            }
            // Remove Old Condition On Product
            Cart::session($userToken)->removeItemCondition($cartKey, 'product_coupon');

            if (count($prdListIds) > 0 && in_array($prdId, $prdListIds)) {

                if ($coupon->discount_type == "value") {
                    $discount_value = $coupon->discount_value;
                    $totalValue += intval($cartItem->quantity) * $discount_value;
                } elseif ($coupon->discount_type == "percentage") {
                    $discount_value = (floatval($cartItem->price) * $coupon->discount_percentage) / 100;
                    $totalValue += $discount_value * intval($cartItem->quantity);
                }
                $prdCoupon = new CartCondition(array(
                    'name' => 'product_coupon',
                    'type' => 'product_coupon',
                    'value' => number_format($discount_value * -1, 3),
                ));
                addItemCondition($cartKey, $prdCoupon, $userToken);
                $this->saveEmptyDiscountCouponCondition($coupon, $userToken); // to use it to check coupon in order
            }
        }
        return $totalValue;
    }

    /*
     *** End - Check Frontend Coupon
     */
}
