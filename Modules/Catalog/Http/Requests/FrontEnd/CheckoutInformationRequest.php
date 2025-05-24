<?php

namespace Modules\Catalog\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutInformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->address_type == 'unknown_address') {
            $rules = [
                'sender_name' => 'required|max:255',
                'sender_mobile' => 'required|max:20',
            ];
        } elseif ($this->address_type == 'known_address') {
            $rules = [
                'state_id' => 'required|numeric',
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
            'sender_name.required' => __('catalog::frontend.checkout.address.validation.sender_name.required'),
            'sender_name.max' => __('catalog::frontend.checkout.address.validation.sender_name.max'),
            'sender_mobile.required' => __('catalog::frontend.checkout.address.validation.sender_mobile.required'),
            'sender_mobile.max' => __('catalog::frontend.checkout.address.validation.sender_mobile.max'),

            'selected_address_id.required' => __('catalog::frontend.checkout.address.validation.selected_address_id.required'),

            'state_id.required' => __('user::frontend.addresses.validations.state_id.required'),
            'state_id.numeric' => __('user::frontend.addresses.validations.state_id.numeric'),
            'address.required' => __('user::frontend.addresses.validations.address.required'),
            'address.string' => __('user::frontend.addresses.validations.address.string'),
            'address.min' => __('user::frontend.addresses.validations.address.min'),
            'block.required' => __('user::frontend.addresses.validations.block.required'),
            'block.string' => __('user::frontend.addresses.validations.block.string'),
            'street.required' => __('user::frontend.addresses.validations.street.required'),
            'street.string' => __('user::frontend.addresses.validations.street.string'),
            'building.required' => __('user::frontend.addresses.validations.building.required'),
            'building.string' => __('user::frontend.addresses.validations.building.string'),


        ];

        return $v;
    }
}
