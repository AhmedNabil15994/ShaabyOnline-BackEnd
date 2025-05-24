<?php

namespace Modules\Cart\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Support\Str;
use Modules\Cart\Entities\DatabaseStorageModel;
use Modules\Catalog\Entities\AddonOption;
use Modules\Catalog\Entities\Product;
use Modules\Variation\Entities\ProductVariant;
use Modules\Vendor\Traits\VendorTrait;

trait CartTrait
{
    use VendorTrait;

    protected $vendorCondition = 'vendor';
    protected $deliveryCondition = 'delivery_fees';
    protected $companyDeliveryCondition = 'company_delivery_fees';
    protected $vendorCommission = 'commission';
    protected $DiscountCoupon = 'coupon_discount';

    public function getCart($userId)
    {
        return Cart::session($userId);
    }

    public function findItemById($request, $id)
    {
        $cart = $this->getCart($request['user_token']);
        $item = $cart->getContent()->get($id);
        return $item;
    }

    public function getVendor($data)
    {
        $cart = $this->getCart($data['user_token']);
        $vendor = $cart->getCondition('vendor')->getType();
        return $vendor;
    }

    public function addOrUpdateCart($product, $request)
    {
        $checkProductStatus = $this->checkProductStatus($product);
        $checkQty = $this->checkQty($product);
        $checkMaxQty = $this->checkMaxQty($product, $request->qty);
        $vendorStatus = $this->vendorStatus($product, $request);
        $checkPrdActiveStatus = $this->checkProductActiveStatus($product, $request);

        if ($checkProductStatus) {
            return $checkProductStatus;
        }

        if ($vendorStatus) {
            return $vendorStatus;
        }

        if ($checkQty) {
            return $checkQty;
        }

        if ($checkMaxQty) {
            return $checkMaxQty;
        }

        if ($checkPrdActiveStatus) {
            return $checkPrdActiveStatus;
        }

        if (!$this->addOrUpdate($product, $request)) {
            return false;
        }

    }

    public function addOrUpdate($product, $request)
    {
        $item = $this->findItemById($request, $product->product_type == 'product' ? $product->id : 'var-' . $product->id);

        if (!is_null($item)) {

            if (!$this->updateCart($product, $request)) {
                return false;
            }

        } else {

            if (!$this->add($product, $request)) {
                return false;
            }

        }
    }

    public function add($product, $request)
    {
        $cart = $this->getCart($request['user_token']);

        $attributes = [
            'type' => 'simple',
            'image' => $product->image,
            'sku' => $product->sku,
            'old_price' => $product->offer ? $product->price : null,
            'product_type' => $product->product_type,
            'product' => $product,
            'notes' => $request->notes ?? null,
            'vendor_id' => $product->vendor_id ?? null,
        ];

        if ($product->product_type == 'variation') {
            $productName = generateVariantProductData($product->product, $product->product->id, json_decode($request->selectedOptionsValue))['name'];
            $attributes['slug'] = Str::slug($productName);
            $attributes['selectedOptions'] = json_decode($request->selectedOptions);
            $attributes['selectedOptionsValue'] = json_decode($request->selectedOptionsValue);
        } else {
            $productName = $product->title;
            $attributes['slug'] = $product->slug;
        }

        $addonsOptionsTotal = 0;
        if (isset($request->addonsOptions) && !empty($request->addonsOptions)) {
            $addonsOptionsResult = $this->getAddonsOptionsTotalAmount($request->addonsOptions);
            $addonsOptionsTotal = floatval($addonsOptionsResult['total']);
            $attributes['addonsOptions']['data'] = $request->addonsOptions;
            $attributes['addonsOptions']['total_amount'] = number_format($addonsOptionsTotal, 3);
            $attributes['addonsOptions']['addonsPriceObject'] = $addonsOptionsResult['addonsPriceObject'];
        }

        $cartArr = [
            'id' => $product->product_type == 'product' ? $product->id : 'var-' . $product->id,
            'name' => $productName,
            'quantity' => $request->qty ? intval($request->qty) : +1,
            'attributes' => $attributes,
        ];
        // $cartArr['price'] = $product->offer ? $product->offer->offer_price : $product->price;

        if ($product->offer) {
            if (!is_null($product->offer->offer_price)) {
                $cartArr['price'] = $product->offer->offer_price;
            } elseif (!is_null($product->offer->percentage)) {
                $percentageResult = (floatval($product->price) * floatVal($product->offer->percentage)) / 100;
                $cartArr['price'] = floatval($product->price) - $percentageResult;
            } else {
                $cartArr['price'] = floatval($product->price);
            }
        } else {
            $cartArr['price'] = floatval($product->price);
        }

        $cartArr['price'] = $cartArr['price'] + $addonsOptionsTotal;

        $addToCart = $cart->add($cartArr);
        return true;
    }

    public function updateCart($product, $request)
    {
        $cart = $this->getCart($request['user_token']);

        ### Start Update Cart Attributes ###

        $attributes = [
            'type' => 'simple',
            'image' => $product->image,
            'sku' => $product->sku,
            'old_price' => $product->offer ? $product->price : null,
            'product_type' => $product->product_type,
            'product' => $product,
            'notes' => $request->notes ?? null,
            'vendor_id' => $product->vendor_id ?? null,
        ];

        if ($product->product_type == 'variation') {
            $productName = generateVariantProductData($product->product, $product->product->id, json_decode($request->selectedOptionsValue))['name'];
            $attributes['slug'] = Str::slug($productName);
            $attributes['selectedOptions'] = json_decode($request->selectedOptions);
            $attributes['selectedOptionsValue'] = json_decode($request->selectedOptionsValue);
        } else {
            $productName = $product->title;
            $attributes['slug'] = $product->slug;
        }

        $addonsOptionsTotal = 0;
        if (isset($request->addonsOptions) && !empty($request->addonsOptions)) {
            $addonsOptionsResult = $this->getAddonsOptionsTotalAmount($request->addonsOptions);
            $addonsOptionsTotal = floatval($addonsOptionsResult['total']);
            $attributes['addonsOptions']['data'] = $request->addonsOptions;
            $attributes['addonsOptions']['total_amount'] = number_format($addonsOptionsTotal, 3);
            $attributes['addonsOptions']['addonsPriceObject'] = $addonsOptionsResult['addonsPriceObject'];
        }

        ### End Update Cart Attributes ###

        $cartArr = [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty ? intval($request->qty) : +1,
            ],
            'attributes' => $attributes,
        ];

        if ($product->offer) {
            if (!is_null($product->offer->offer_price)) {
                $cartArr['price'] = $product->offer->offer_price;
            } elseif (!is_null($product->offer->percentage)) {
                $percentageResult = (floatval($product->price) * floatVal($product->offer->percentage)) / 100;
                $cartArr['price'] = floatval($product->price) - $percentageResult;
            } else {
                $cartArr['price'] = floatval($product->price);
            }
        } else {
            $cartArr['price'] = floatval($product->price);
        }

        $cartArr['price'] = $cartArr['price'] + $addonsOptionsTotal;

        $updateItem = $cart->update($product->product_type == 'product' ? $product->id : 'var-' . $product->id, $cartArr);

        if (!$updateItem) {
            return false;
        }

        return true;
    }

    /* ######################## Start - Check Cart Product Conditions ######################### */

    public function checkProductStatus($product)
    {
        if ($product->product_type == 'product') {
            $productTitle = $product->title;

            if ($product->status == 0 || $product->pending_for_approval == 0 || !is_null($product->deleted_at)) {
                return $errors = $productTitle . ' - ' . __('catalog::frontend.products.alerts.product_is_not_active');
            }

        } else {
            $productTitle = $product->product->title;

            if ($product->product->deleted_at != null || $product->product->status == 0 || $product->product->pending_for_approval == 0 || $product->status == 0) {
                return $errors = $productTitle . ' - ' . __('catalog::frontend.products.alerts.product_is_not_active');
            }
        }

        return false;
    }

    public function vendorExist($product, $request)
    {
        $cart = $this->getCart($request['user_token']);
        $vendor = $cart->getCondition('vendor');
        if ($vendor) {
            if ($vendor->getType() != $product->vendor_id) {
                return $errors = __('cart::api.validation.cart.vendor_not_match');
            }

        }
        return false;
    }

    public function vendorStatus($product, $request = null)
    {
        $vendor = $product->product_type == 'variation' ? $product->product->vendor : $product->vendor;
        if ($vendor) {

            if ($vendor->vendor_status_id == 4 || ( /* config('setting.other.select_shipping_provider') == 'vendor_delivery' && */!$this->isAvailableVendorWorkTime($vendor->id))) {
                return $errors = __('catalog::frontend.products.alerts.vendor_is_busy');
            }

            ### Check if vendor status is 'opened' OR 'closed'
            /* if ($vendor->vendor_status_id == 3 || $vendor->vendor_status_id == 4)
        return $errors = __('catalog::frontend.products.alerts.vendor_is_busy'); */
        }
        return false;
    }

    // CHECK IF QTY PRODUCT IN DB IS MORE THAN 0
    public function checkQty($product)
    {
        $productTitle = $product->product_type == 'product' ? $product->title : $product->product->title;
        if (!is_null($product->qty) && intval($product->qty) <= 0) {
            return $productTitle . ' - ' . __('catalog::frontend.products.alerts.product_qty_less_zero');
        }

        return false;
    }

    // CHECK IF USER REQUESTED QTY MORE THAN MAXIMUM OF PRODUCT QTY
    public function checkMaxQty($product, $qty)
    {
        $productTitle = $product->product_type == 'product' ? $product->title : $product->product->title;
        if ($product && !is_null($product->qty) && intval($qty) > intval($product->qty)) {
            return $productTitle . ' - ' . __('catalog::frontend.products.alerts.qty_more_than_max') . $product->qty;
        }

        return false;
    }

    public function checkProductActiveStatus($product, $request)
    {
        if ($product) {
            if ($product->product_type == 'product') {

                if ($product->deleted_at != null || $product->status == 0) {
                    return $product->title . ' - ' .
                    __('catalog::frontend.products.alerts.qty_is_not_active');
                }

            } else {
                if ($product->product->deleted_at != null || $product->product->status == 0 || $product->status == 0) {
                    return $product->product->title . ' - ' .
                    __('catalog::frontend.products.alerts.qty_is_not_active');
                }

            }
        }
        return false;
    }

    public function productFound($product, $cartProduct)
    {
        if (!$product) {
            if ($cartProduct->attributes->product->product_type == 'product') {
                return $cartProduct->attributes->product->title . ' - ' .
                __('catalog::frontend.products.alerts.product_not_available');
            } else {
                return $cartProduct->attributes->product->product->title . ' - ' .
                __('catalog::frontend.products.alerts.product_not_available');
            }
        }

        return false;
    }

    /* ######################## End - Check Cart Product Conditions ######################### */

    /* ######################## Start - Add Cart Conditions ######################### */

    public function discountCouponCondition($coupon, $discount_value, $request)
    {
        $cart = $this->getCart($request['user_token']);

        $coupon_discount = new CartCondition([
            'name' => $this->DiscountCoupon,
            'type' => $this->DiscountCoupon,
            'target' => 'subtotal',
            'value' => (string) number_format($discount_value * -1, 3),
            'attributes' => [
                'coupon' => $coupon,
            ],
        ]);

        $cart->condition([$coupon_discount]);
        return true;
    }

    public function saveEmptyDiscountCouponCondition($coupon, $userToken = null)
    {
        $coupon_discount = new CartCondition([
            'name' => $this->DiscountCoupon,
            'type' => $this->DiscountCoupon,
            'target' => 'subtotal',
            // 'target' => 'total',
            'value' => (string) 0,
            'attributes' => [
                'coupon' => $coupon,
            ],
        ]);

        return Cart::session($userToken)->condition([$coupon_discount]);
    }

    public function companyDeliveryChargeCondition($request, $price, $delivery_time = null)
    {
        $cart = $this->getCart($request['user_token']);

        $deliveryFees = new CartCondition([
            'name' => $this->companyDeliveryCondition,
            'type' => $this->companyDeliveryCondition,
            'target' => 'total',
            'value' => (string) $price,
            'attributes' => [
                'state_id' => $request->state_id,
                'address_id' => $request->address_id ?? null,
                'vendor_id' => $request->vendor_id ?? null,
                'delivery_time_note' => $delivery_time,
            ],
        ]);

        $cart->condition([$deliveryFees]);
        return true;
    }

    /* ######################## End - Add Cart Conditions ######################### */

    public function removeItem($data, $id)
    {
        $cart = $this->getCart($data['user_token']);
        $cartItem = $cart->remove($id);

        if ($cart->getContent()->count() <= 0) {
            $cart->clear();
            $cart->clearCartConditions();
        }
        return $cartItem;
    }

    public function clearCart($userToken)
    {
        $cart = $this->getCart($userToken);
        $cart->clear();
        $cart->clearCartConditions();

        return true;
    }

    public function cartDetails($data)
    {
        $cart = $this->getCart($data['user_token']);
        $items = [];
        foreach ($cart->getContent() as $key => $item) {
            if ($item->attributes->product->product_type == 'product') {
                $currentProduct = Product::find($item->attributes->product->id);
                if (is_null($currentProduct)) {
                    $this->removeItem($data, $item->id);
                    break;
                }
            } else {
                $currentProduct = ProductVariant::find($item->attributes->product->id);
                if (is_null($currentProduct)) {
                    $this->removeItem($data, $item->id);
                    break;
                }
            }
            $items[] = $item;
        }
        return $items;

        /*return $cart->getContent()->each(function ($item) use (&$items) {
    $items[] = $item;
    });*/
    }

    public function getCartConditions($request)
    {
        $cart = $this->getCart($request['user_token']);
        $res = [];
        if (count($cart->getConditions()->toArray()) > 0) {
            $i = 0;
            foreach ($cart->getConditions() as $k => $condition) {
                $res[$i]['target'] = $condition->getTarget(); // the target of which the condition was applied
                $res[$i]['name'] = $condition->getName(); // the name of the condition
                $res[$i]['type'] = $condition->getType(); // the type
                $res[$i]['value'] = $condition->getValue(); // the value of the condition
                $res[$i]['order'] = $condition->getOrder(); // the order of the condition
                $res[$i]['attributes'] = $condition->getAttributes(); // the attributes of the condition, returns an empty [] if no attributes added

                $i++;
            }
        }
        return $res;
    }

    public function getCondition($request, $name)
    {
        $cart = $this->getCart($request['user_token']);
        $condition = $cart->getCondition($name);
        return $condition;
    }

    public function removeConditionByName($request, $name)
    {
        $cart = $this->getCart($request['user_token']);
        $cart->removeCartCondition($name);
        return true;
    }

    public function cartTotal($data)
    {
        $cart = $this->getCart($data['user_token']);
        return $cart->getTotal();
    }

    public function cartSubTotal($data)
    {
        $cart = $this->getCart($data['user_token']);
        return $cart->getSubTotal();
    }

    public function cartCount($data)
    {
        $cart = $this->getCart($data['user_token']);
        return $cart->getContent()->count();
    }

    public function updateCartKey($userToken, $newUserId)
    {
        DatabaseStorageModel::where('id', $userToken . '_cart_conditions')->update(['id' => $newUserId . '_cart_conditions']);
        DatabaseStorageModel::where('id', $userToken . '_cart_items')->update(['id' => $newUserId . '_cart_items']);
        return true;
    }

    public function removeCartConditionByType($type = '', $userToken = null)
    {
        Cart::session($userToken)->removeConditionsByType($type);
        return true;
    }

    public function checkProductAddonsValidation($selectedAddons, $product)
    {
        $userSelections = !empty($selectedAddons) ? array_column($selectedAddons, 'id') : [];
        if ($product->addOns->where('type', 'single')->count() > 0) {
            $productSingleAddons = $product->addOns->where('type', 'single')->pluck('addon_category_id')->toArray();
            $intersectArray = array_values(array_map('intval', array_intersect($userSelections, $productSingleAddons)));
            if (count($intersectArray) == 0 || (count($intersectArray) > 0 && count($intersectArray) != count($productSingleAddons))) {
                return __('cart::api.cart.product.select_single_addons');
            } else {
                return true;
            }

        }
        return true;
    }

    public function getAddonsOptionsTotalAmount($addOnOptions)
    {
        $priceObject = [];
        $total = 0;
        $index = 0;
        foreach ($addOnOptions as $k => $items) {
            if (isset($items['options']) && count($items['options']) > 0) {
                foreach ($items['options'] as $i => $item) {
                    $price = AddonOption::find($item)->price;
                    $total += floatval(number_format($price, 3));
                    $priceObject[$index]['id'] = $item;
                    $priceObject[$index]['amount'] = number_format($price, 3);
                    $index++;
                }
            }
        }
        return [
            'total' => $total,
            'addonsPriceObject' => $priceObject,
        ];
    }
}
