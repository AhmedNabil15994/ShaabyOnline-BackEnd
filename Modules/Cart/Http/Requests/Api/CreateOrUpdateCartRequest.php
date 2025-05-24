<?php

namespace Modules\Cart\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductAddon;

class CreateOrUpdateCartRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'user_token' => 'required',
            // 'pickup_delivery_type' => 'required|in:delivery,pickup',
        ];
        return $rules;
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $messages = [
            'user_token.required' => __('apps::frontend.general.user_token_not_found'),
            /* 'pickup_delivery_type.required' => __('cart::api.validations.pickup_delivery_type.required'),
            'pickup_delivery_type.in' => __('cart::api.validations.pickup_delivery_type.in') . 'delivery, pickup', */
        ];
        return $messages;
    }

    public function withValidator($validator)
    {
        if (auth('api')->check())
            $userToken = auth('api')->user()->id;
        else
            $userToken = $this->user_token ?? null;

        $cartProduct = Product::with('addOns')->find($this->product_id);
        $productAddonCategoriesError = $this->printProductAddonCatValidation($cartProduct);

        $validator->after(function ($validator) use ($userToken, $productAddonCategoriesError) {

            if ($this->product_type == 'product') {
                if (isset($this->addonsOptions) && !empty($this->addonsOptions)) {
                    foreach ($this->addonsOptions as $k => $value) {

                        $addOns = ProductAddon::where('product_id', $this->product_id)->where('addon_category_id', $value['id'])->first();
                        if (!$addOns) {
                            return $validator->errors()->add(
                                'addons',
                                __('cart::api.validations.addons.addons_not_found') . ' - ' . __('cart::api.validations.addons.addons_number') . ': ' . $value['id']
                            );
                        }

                        $optionsIds = $addOns->addonOptions ? $addOns->addonOptions->pluck('addon_option_id')->toArray() : [];
                        if ($addOns->type == 'single' && isset($value['options']) && !in_array($value['options'][0], $optionsIds)) {
                            return $validator->errors()->add(
                                'addons',
                                __('cart::api.validations.addons.option_not_found') . ' - ' . __('cart::api.validations.addons.addons_number') . ': ' . $value['options'][0]
                            );
                        }

                        if ($addOns->type == 'multi') {
                            if ($addOns->max_options_count != null && isset($value['options']) && count($value['options']) > intval($addOns->max_options_count)) {
                                return $validator->errors()->add(
                                    'addons',
                                    __('cart::api.validations.addons.selected_options_greater_than_options_count') . ': ' . $addOns->addonCategory->getTranslation('title', locale())
                                );
                            }

                            if ($addOns->min_options_count != null && isset($value['options']) && count($value['options']) < intval($addOns->min_options_count)) {
                                return $validator->errors()->add(
                                    'addons',
                                    __('cart::api.validations.addons.selected_options_less_than_options_count') . ': ' . $addOns->addonCategory->getTranslation('title', locale())
                                );
                            }

                            if (isset($value['options']) && count($value['options']) > 0) {
                                foreach ($value['options'] as $i => $item) {
                                    if (!in_array($item, $optionsIds)) {
                                        return $validator->errors()->add(
                                            'addons',
                                            __('cart::api.validations.addons.option_not_found') . ' - ' . __('cart::api.validations.addons.addons_number') . ': ' . $item
                                        );
                                    }
                                }
                            }
                        }
                    }
                }

                if (!empty($productAddonCategoriesError)) {
                    $msg = implode(', ', $productAddonCategoriesError);
                    return $validator->errors()->add(
                        'addons',
                        __('cart::api.validations.addons.select_required_product_addon_category') . ': ' . $msg
                    );
                }
            }
        });
        return true;
    }

    private function printProductAddonCatValidation($cartProduct)
    {
        $msg = [];
        if (!empty($cartProduct->addOns) && empty($this->addonsOptions)) {
            foreach ($cartProduct->addOns as $k => $addon) {
                if ($addon && $addon->is_required == 1) {
                    $msg[] = $addon->addonCategory->title;
                }
            }
        } elseif (!empty($this->addonsOptions)) {
            $productAddonCategories = array_column($cartProduct->addOns->toArray() ?? [], 'addon_category_id');
            $diffAddonCats = array_values(array_diff($productAddonCategories, array_map('intval', array_column($this->addonsOptions ?? [], 'id') ?? [])));
            if (!empty($diffAddonCats)) {
                foreach ($diffAddonCats as $k => $id) {
                    $addOns = ProductAddon::where('product_id', $this->product_id)->where('addon_category_id', $id)->first();
                    if ($addOns && $addOns->is_required == 1) {
                        $msg[] = $addOns->addonCategory->title;
                    }
                }
            }
        }
        return $msg;
    }
}
