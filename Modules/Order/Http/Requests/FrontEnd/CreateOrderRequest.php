<?php

namespace Modules\Order\Http\Requests\FrontEnd;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Cart;
use Modules\Company\Entities\DeliveryCharge;
use Modules\Vendor\Entities\Vendor;
use Modules\Vendor\Entities\VendorDeliveryCharge;
use Illuminate\Support\Str;
use Modules\Company\Entities\Company;
use Modules\Vendor\Traits\VendorTrait;

class CreateOrderRequest extends FormRequest
{
    use VendorTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->address_type == 'unknown_address') {
            $rules = [
                'state_id' => 'required|numeric',
                'receiver_name' => 'required|max:255',
                'receiver_mobile' => 'required|max:20',
            ];
        } elseif ($this->address_type == 'known_address') {
            $rules = [
                'state_id' => 'required|numeric',
                'mobile' => 'required|string',
                //                'mobile' => 'required|string|min:8|max:8',
                'block' => 'required|string',
                'street' => 'required|string',
                'building' => 'required|string',
                'address' => 'nullable|string|min:10',
            ];
        } elseif ($this->address_type == 'selected_address') {
            $rules = [
                'selected_address_id' => 'required',
            ];
        } else {
            $rules = [
                'address_type' => 'required|in:unknown_address,known_address,selected_address',
            ];
        }

        // $rules['payment'] = 'required|in:cash,online';

        $rules['payment'] = 'required';
        $rules['shipping.type'] = 'nullable|in:direct,schedule';

        /* $rules['shipping_company.id'] = 'nullable';
        $rules['shipping_company.day'] = 'nullable'; */


        /*$rules['vendors_ids'] = 'required|array';
        if (count($this->vendors_ids) > 0) {
            foreach ($this->vendors_ids as $k => $vendorId) {
                $rules['vendor_company.' . $vendorId] = 'required';
            }
            foreach ($this->vendor_company as $vendorId => $companyId) {
                $rules['vendor_company_day.' . $vendorId . '.' . $companyId] = 'required';
            }
        }*/

        //        dd($rules);

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'address_type.required' => __('catalog::frontend.checkout.address.validation.address_type.required'),
            'address_type.in' => __('catalog::frontend.checkout.address.validation.address_type.in'),
            'receiver_name.required' => __('catalog::frontend.checkout.address.validation.receiver_name.required'),
            'receiver_name.max' => __('catalog::frontend.checkout.address.validation.receiver_name.max'),
            'receiver_mobile.required' => __('catalog::frontend.checkout.address.validation.receiver_mobile.required'),
            'receiver_mobile.max' => __('catalog::frontend.checkout.address.validation.receiver_mobile.max'),

            'selected_address_id.required' => __('catalog::frontend.checkout.address.validation.selected_address_id.required'),

            'state_id.required' => __('user::frontend.addresses.validations.state_id.required'),
            'state_id.numeric' => __('user::frontend.addresses.validations.state_id.numeric'),
            'mobile.required' => __('user::frontend.addresses.validations.mobile.required'),
            'mobile.numeric' => __('user::frontend.addresses.validations.mobile.numeric'),
            'mobile.digits_between' => __('user::frontend.addresses.validations.mobile.digits_between'),
            'mobile.min' => __('user::frontend.addresses.validations.mobile.min'),
            'mobile.max' => __('user::frontend.addresses.validations.mobile.max'),
            'address.required' => __('user::frontend.addresses.validations.address.required'),
            'address.string' => __('user::frontend.addresses.validations.address.string'),
            'address.min' => __('user::frontend.addresses.validations.address.min'),
            'block.required' => __('user::frontend.addresses.validations.block.required'),
            'block.string' => __('user::frontend.addresses.validations.block.string'),
            'street.required' => __('user::frontend.addresses.validations.street.required'),
            'street.string' => __('user::frontend.addresses.validations.street.string'),
            'building.required' => __('user::frontend.addresses.validations.building.required'),
            'building.string' => __('user::frontend.addresses.validations.building.string'),

            'payment.required' => __('order::frontend.orders.validations.payment.required'),
            'payment.in' => __('order::frontend.orders.validations.payment.in'),

            'shipping_company.id.required' => __('catalog::frontend.checkout.validation.vendor_company.required'),
            'shipping_company.day.required' => __('catalog::frontend.checkout.validation.vendor_company_day.required'),

        ];

        /*if (count($this->vendors_ids) > 0) {
            foreach ($this->vendors_ids as $k => $vendorId) {
                $v['vendor_company.' . $vendorId . '.required'] = __('catalog::frontend.checkout.validation.vendor_company.required');
            }
            foreach ($this->vendor_company as $vendorId => $companyId) {
                $v['vendor_company_day.' . $vendorId . '.' . $companyId . '.required'] = __('catalog::frontend.checkout.validation.vendor_company_day.required');
            }
        }*/

        return $v;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $companyDeliveryFees = getCartConditionByName(null, 'company_delivery_fees');

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

                $vendorId = getCartContent()->first()->attributes['vendor_id'] ?? null;
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

                $this->request->add(['shipping' => [
                    'type' => 'schedule',
                    'date' => $this->shipping['date'],
                    'time_from' => $this->shipping[$this->shipping['day']]['time_from'],
                    'time_to' => $this->shipping[$this->shipping['day']]['time_to'],
                ]]);

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

                $this->request->add(['shipping' => [
                    'type' => 'direct',
                    'message' => $deliveryProvider->direct_delivery_message,
                ]]);
            }
            ### End: Checking vendor delivery time ###

            ### Start Checking minimum order validation ###
            if (!$delivery) {
                return $validator->errors()->add(
                    'delivery_charge',
                    __('order::api.orders.validations.delivery_charge.not_found')
                );
            } else {
                if (!is_null($delivery->min_order_amount) && getCartTotal() < floatval($delivery->min_order_amount)) {
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
