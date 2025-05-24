<?php

namespace Modules\Coupon\Http\Requests\FrontEnd;

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
                    'code' => 'required|exists:coupons,code',
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
            'code.required' => __('coupon::frontend.coupons.validation.code.required'),
            'code.exists' => __('coupon::frontend.coupons.validation.code.exists'),
        ];


        return $v;

    }
}
