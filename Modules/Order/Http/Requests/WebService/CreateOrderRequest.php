<?php

namespace Modules\Order\Http\Requests\WebService;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Company\Entities\DeliveryCharge;
use Modules\Vendor\Entities\Vendor;
use Modules\Vendor\Entities\VendorDeliveryCharge;
use Illuminate\Support\Str;
use Modules\Company\Entities\Company;
use Modules\Vendor\Traits\VendorTrait;

class CreateOrderRequest extends FormRequest
{
    use VendorTrait;

    public function rules()
    {
        if ($this->address_type == 'guest_address') {
            $rules = [
                'address.username' => 'nullable|string',
                'address.email' => 'nullable|email',
                'address.state_id' => 'required|numeric',
                'address.mobile' => 'required|string',
                //                'address.mobile' => 'required|string|min:8|max:8',
                'address.block' => 'required|string',
                'address.street' => 'required|string',
                'address.building' => 'required|string',
                'address.address' => 'nullable|string',
            ];
        } elseif ($this->address_type == 'selected_address') {
            $rules = [
                'address.selected_address_id' => 'nullable',
            ];
        } else {
            $rules = [
                'address_type' => 'required|in:guest_address,selected_address',
            ];
        }

        //        $rules['user_id'] = 'nullable|exists:users,id';
        // $rules['payment'] = 'required|in:cash,online';

        $rules['payment'] = 'required';
        if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
            $rules['shipping.type'] = 'required|in:direct,schedule';
        }

        /* $rules['shipping_company.availabilities.day_code'] = 'nullable';
        $rules['shipping_company.availabilities.day'] = 'nullable'; */

        return $rules;
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $messages = [
            'address_type.required' => __('order::api.address.validations.address_type.required'),
            'address_type.in' => __('order::api.address.validations.address_type.in'),
            'selected_address_id.required' => __('order::api.address.validations.selected_address_id.required'),

            'address.username.string' => __('order::api.address.validations.username.string'),
            'address.email.email' => __('order::api.address.validations.email.email'),
            'address.state_id.required' => __('order::api.address.validations.state_id.required'),
            'address.state_id.numeric' => __('order::api.address.validations.state_id.numeric'),
            'address.mobile.required' => __('order::api.address.validations.mobile.required'),
            'address.mobile.numeric' => __('order::api.address.validations.mobile.numeric'),
            'address.mobile.digits_between' => __('order::api.address.validations.mobile.digits_between'),
            'address.mobile.min' => __('order::api.address.validations.mobile.min'),
            'address.mobile.max' => __('order::api.address.validations.mobile.max'),
            'address.address.required' => __('order::api.address.validations.address.required'),
            'address.address.string' => __('order::api.address.validations.address.string'),
            'address.address.min' => __('order::api.address.validations.address.min'),
            'address.block.required' => __('order::api.address.validations.block.required'),
            'address.block.string' => __('order::api.address.validations.block.string'),
            'address.street.required' => __('order::api.address.validations.street.required'),
            'address.street.string' => __('order::api.address.validations.street.string'),
            'address.building.required' => __('order::api.address.validations.building.required'),
            'address.building.string' => __('order::api.address.validations.building.string'),

            'user_id.exists' => __('order::api.orders.validations.user_id.exists'),
            'payment.required' => __('order::api.payment.validations.required'),
            'payment.in' => __('order::api.payment.validations.in') . ' cash,online',

            'shipping_company.availabilities.day_code.required' => __('order::api.shipping_company.validations.day_code.required'),
            'shipping_company.availabilities.day.required' => __('order::api.shipping_company.validations.day.required'),
        ];

        return $messages;
    }

    public function withValidator($validator)
    {
        if (auth('api')->check())
            $userToken = auth('api')->user()->id;
        else
            $userToken = $this->user_id ?? null;

        $validator->after(function ($validator) use ($userToken) {

            if (auth('api')->guest() && is_null($this->user_id)) {
                return $validator->errors()->add(
                    'user_id',
                    __('order::api.orders.validations.user_id.required')
                );
            }

            if (count(getCartContent($userToken)) <= 0) {
                return $validator->errors()->add(
                    'cart',
                    __('order::api.orders.validations.cart.required')
                );
            }

            $companyDeliveryFees = getCartConditionByName($userToken, 'company_delivery_fees');

            if (is_null($companyDeliveryFees)) {
                return $validator->errors()->add(
                    'company_delivery_fees',
                    __('order::api.orders.validations.company_delivery_fees.required')
                );
            }

            $stateId = $companyDeliveryFees->getAttributes()['state_id'] ?? null;

            if (auth('api')->check() && $companyDeliveryFees != null && empty($companyDeliveryFees->getAttributes()['address_id'])) {
                return $validator->errors()->add(
                    'address_id',
                    __('order::api.orders.validations.address_id.required')
                );
            }

            if (config('setting.other.select_shipping_provider') == 'shipping_company') {
                $companyId = config('setting.other.shipping_company') ?? 0;
                $delivery = DeliveryCharge::active()->where('state_id', $stateId)->where('company_id', $companyId)->first();
                $deliveryProvider = Company::with([/*'workTimes',*/'deliveryTimes'])->find($companyId);
            } elseif (config('setting.other.select_shipping_provider') == 'vendor_delivery') {

                $vendorId = getCartContent($userToken)->first()->attributes['vendor_id'] ?? null;
                $delivery = VendorDeliveryCharge::active()->where('state_id', $stateId)->where('vendor_id', $vendorId)->first();
                $deliveryProvider = Vendor::with([/*'workTimes',*/'deliveryTimes'])->find($vendorId);

                ### End - Checking vendor payment methods ###

                ### Start: Checking vendor work time ###
                if ($deliveryProvider->vendor_status_id == 4 || !$this->isAvailableVendorWorkTime($deliveryProvider->id)) {
                    return $validator->errors()->add(
                        'vendor_status',
                        __('catalog::frontend.products.alerts.vendor_is_busy')
                    );
                }
                ### End: Checking vendor work time ###
            }

            if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                $shippingType = $this->shipping['type'] ?? null;
                if ($shippingType == null) {
                    return $validator->errors()->add(
                        'shipping_type',
                        __('order::api.orders.validations.shipping.type.required')
                    );
                }

                ### Start: Checking vendor delivery time ###
                if ($shippingType == 'schedule') {

                    if (!in_array('schedule', $deliveryProvider->delivery_time_types ?? [])) {
                        return $validator->errors()->add(
                            'delivery_time_types',
                            __('order::api.orders.validations.vendor_delivery_time_types.not_found')
                        );
                    }

                    if (isset($this->shipping['date']) && isset($this->shipping['time_from']) && isset($this->shipping['time_to'])) {
                        $date = Carbon::parse($this->shipping['date']);
                        $shortDay = Str::lower($date->format('D'));
                        $vendorDeliveryTime = $deliveryProvider->deliveryTimes->where('day_code', $shortDay)->first();
                        if ($vendorDeliveryTime) {
                            if ($vendorDeliveryTime->is_full_day == 0) { // if one: it should be accepted because vendor works all day long
                                // check if incoming time match custom time
                                $check = collect($vendorDeliveryTime->custom_times)->where('time_from', $this->shipping['time_from'])->where('time_to', $this->shipping['time_to'])->first();
                                if (is_null($check)) {
                                    return $validator->errors()->add(
                                        'time_not_match',
                                        __('order::api.orders.validations.shipping_time.time_not_match')
                                    );
                                }
                            }
                        } else {
                            return $validator->errors()->add(
                                'day_not_available',
                                __('order::api.orders.validations.shipping_time.day_not_available')
                            );
                        }
                    }
                } else { // direct order without delivery time

                    if (!in_array('direct', $deliveryProvider->delivery_time_types ?? [])) {
                        return $validator->errors()->add(
                            'delivery_time_types',
                            __('order::api.orders.validations.vendor_delivery_time_types.not_found')
                        );
                    }

                    $this->request->add(['shipping' => ['message' => $deliveryProvider->direct_delivery_message]]);
                }
            }
            ### End: Checking vendor delivery time ###

            ### Start Checking minimum order validation ###
            if (!$delivery) {
                return $validator->errors()->add(
                    'delivery_charge',
                    __('order::api.orders.validations.delivery_charge.not_found')
                );
            } else {
                if (!is_null($delivery->min_order_amount) && getCartTotal($userToken) < floatval($delivery->min_order_amount)) {
                    return $validator->errors()->add(
                        'min_order_amount',
                        __('order::api.orders.validations.min_order_amount_greater_than_cart_total') . ': ' . number_format($delivery->min_order_amount, 3)
                    );
                }
            }
            ### End Checking minimum order validation

            if (!in_array($this->payment, array_keys(config('setting.supported_payments') ?? []) ?? []) || config('setting.supported_payments.' . $this->payment . '.status') != 'on') {
                return $validator->errors()->add(
                    'payment',
                    __('order::frontend.orders.index.alerts.payment_not_supported_now')
                );
            }
        });
        return true;
    }
}
