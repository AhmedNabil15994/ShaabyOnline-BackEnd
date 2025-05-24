<?php

namespace Modules\Coupon\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            // handle creates
            case 'post':
            case 'POST':

                return [
                    'user_token' => 'required',
                    'code' => 'required|exists:coupons,code',
//                    'vendor_id' => 'required|exists:vendors,id',
                ];

        }
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
            'user_token.required' => __('cart::api.validations.user_token.required'),
            'code.required' => __('coupon::api.coupons.validation.code.required'),
            'code.exists' => __('coupon::api.coupons.validation.code.exists'),

            /*'vendor_id.required' => __('order::api.orders.validations.vendor.required'),
            'vendor_id.exists' => __('order::api.orders.validations.vendor.exists'),*/
        ];
        return $v;
    }
}
