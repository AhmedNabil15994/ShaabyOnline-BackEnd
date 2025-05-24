<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => 'nullable|string|min:2',
            'mobile' => 'nullable|string|max:11', // with calling_code
            //'mobile' => 'nullable|string|min:8|max:8',
            //'mobile' => 'required|numeric|digits_between:8,8',
            'email' => 'nullable|email',
            'state' => 'required|exists:states,id',
            'block' => 'required|string',
            'street' => 'required|string',
            'building' => 'required|string',
            'address' => 'nullable|string',

            'avenue' => 'nullable|string|max:191',
            'floor' => 'nullable|string|max:191',
            'flat' => 'nullable|string|max:191',
            'automated_number' => 'nullable|string|max:191',
        ];

        switch ($this->getMethod()) {
                // handle creates
            case 'post':
            case 'POST':
                $rules['user_id'] = 'required|exists:users,id';
                return $rules;

            case 'put':
            case 'PUT':
                return $rules;
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
        $messages = [
            'username.required' => __('user::frontend.addresses.validations.username.required'),
            'username.string' => __('user::frontend.addresses.validations.username.string'),
            'username.min' => __('user::frontend.addresses.validations.username.min'),
            'mobile.required' => __('user::frontend.addresses.validations.mobile.required'),
            'mobile.numeric' => __('user::frontend.addresses.validations.mobile.numeric'),
            'mobile.digits_between' => __('user::frontend.addresses.validations.mobile.digits_between'),
            'mobile.min' => __('user::frontend.addresses.validations.mobile.min'),
            'mobile.max' => __('user::frontend.addresses.validations.mobile.max'),
            'email.required' => __('user::frontend.addresses.validations.email.required'),
            'email.email' => __('user::frontend.addresses.validations.email.email'),
            'state.required' => __('user::frontend.addresses.validations.state.required'),
            'state.numeric' => __('user::frontend.addresses.validations.state.numeric'),
            'address.required' => __('user::frontend.addresses.validations.address.required'),
            'address.string' => __('user::frontend.addresses.validations.address.string'),
            'address.min' => __('user::frontend.addresses.validations.address.min'),
            'block.required' => __('user::frontend.addresses.validations.block.required'),
            'block.string' => __('user::frontend.addresses.validations.block.string'),
            'street.required' => __('user::frontend.addresses.validations.street.required'),
            'street.string' => __('user::frontend.addresses.validations.street.string'),
            'building.required' => __('user::frontend.addresses.validations.building.required'),
            'building.string' => __('user::frontend.addresses.validations.building.string'),

            'avenue.required' => __('user::frontend.addresses.validations.avenue.required'),
            'avenue.string' => __('user::frontend.addresses.validations.avenue.string'),
            'avenue.max' => __('user::frontend.addresses.validations.avenue.max') . '191',
            'floor.required' => __('user::frontend.addresses.validations.floor.required'),
            'floor.string' => __('user::frontend.addresses.validations.floor.string'),
            'floor.max' => __('user::frontend.addresses.validations.floor.max') . '191',
            'flat.required' => __('user::frontend.addresses.validations.flat.required'),
            'flat.string' => __('user::frontend.addresses.validations.flat.string'),
            'flat.max' => __('user::frontend.addresses.validations.flat.max') . '191',
            'automated_number.required' => __('user::frontend.addresses.validations.automated_number.required'),
            'automated_number.string' => __('user::frontend.addresses.validations.automated_number.string'),
            'automated_number.max' => __('user::frontend.addresses.validations.automated_number.max') . '191',
        ];

        return $messages;
    }
}
