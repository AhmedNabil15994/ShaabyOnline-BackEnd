<?php

namespace Modules\Catalog\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;
use Cart;

class CheckoutLimitationRequest extends FormRequest
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
            case 'get':
            case 'GET':

                return [
                    'qty' => 'nullable',
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

    public function withValidator($validator)
    {

        $validator->after(function ($validator) {

            if (getCartTotal() < Cart::getCondition('vendor')->getValue()) {
                $validator->errors()->add(
                    'productCart',
                    __('catalog::frontend.checkout.validation.order_limit') . ' ' . Cart::getCondition('vendor')->getValue() . ' KWD'
                );
            }

        });

        return;
    }
}
