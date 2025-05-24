<?php

namespace Modules\Authentication\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            /* 'calling_code' => 'nullable|numeric',
            'mobile' => 'nullable|unique:users,mobile|numeric|digits_between:3,20', */

            'mobile' => [
                'nullable',
                Rule::unique("users")->where(function ($query) {
                    $query->where("mobile", $this->mobile)
                        ->where("calling_code", $this->calling_code ?? '965');
                }),
                'numeric', 'digits_between:3,20',
            ],

            // 'mobile' => 'nullable|unique:users,mobile|numeric',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ];

        if (empty($this->email) && empty($this->mobile)) {
            $rules['email_or_mobile'] = 'required';
        }

        if (!is_null($this->address)) {
            $addressRules = [
                'address.username' => 'nullable|string',
                'address.email' => 'nullable|email',
                'address.state_id' => 'required|numeric|exists:states,id',
                'address.mobile' => 'nullable|string',
                'address.block' => 'nullable|string',
                'address.street' => 'nullable|string',
                'address.building' => 'nullable|string',
                'address.address' => 'nullable|string',
                'address.address_title' => 'nullable|string|max:191',
            ];

            $rules = $rules + $addressRules;
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
            'name.required' => __('authentication::api.register.validation.name.required'),
            'calling_code.required' => __('authentication::api.register.validation.calling_code.required'),
            'calling_code.numeric' => __('authentication::api.register.validation.calling_code.numeric'),
            'calling_code.max' => __('authentication::api.register.validation.calling_code.max'),
            'mobile.required' => __('authentication::api.register.validation.mobile.required'),
            'mobile.unique' => __('authentication::api.register.validation.mobile.unique'),
            'mobile.numeric' => __('authentication::api.register.validation.mobile.numeric'),
            'mobile.digits_between' => __('authentication::api.register.validation.mobile.digits_between'),
            'email.required' => __('authentication::api.register.validation.email.required'),
            'email.unique' => __('authentication::api.register.validation.email.unique'),
            'email.email' => __('authentication::api.register.validation.email.email'),
            'password.required' => __('authentication::api.register.validation.password.required'),
            'password.min' => __('authentication::api.register.validation.password.min'),
            'password.confirmed' => __('authentication::api.register.validation.password.confirmed'),

            'email_or_mobile.required' => __('authentication::api.register.validation.email_or_mobile.required'),
            'firebase_uuid.unique' => __('authentication::api.register.validation.firebase_id.unique'),
            /*'firebase_id.required' => __('authentication::api.register.validation.firebase_id.required'),
            'firebase_id.unique' => __('authentication::api.register.validation.firebase_id.unique'),*/

            'address.username.required' => __('user::frontend.addresses.validations.username.required'),
            'address.username.string' => __('user::frontend.addresses.validations.username.string'),
            'address.username.min' => __('user::frontend.addresses.validations.username.min'),
            'address.mobile.required' => __('user::frontend.addresses.validations.mobile.required'),
            'address.mobile.numeric' => __('user::frontend.addresses.validations.mobile.numeric'),
            'address.mobile.digits_between' => __('user::frontend.addresses.validations.mobile.digits_between'),
            'address.mobile.min' => __('user::frontend.addresses.validations.mobile.min'),
            'address.mobile.max' => __('user::frontend.addresses.validations.mobile.max'),
            'address.email.required' => __('user::frontend.addresses.validations.email.required'),
            'address.email.email' => __('user::frontend.addresses.validations.email.email'),
            'address.state_id.required' => __('user::frontend.addresses.validations.state.required'),
            'address.state_id.numeric' => __('user::frontend.addresses.validations.state.numeric'),
            'address.address.required' => __('user::frontend.addresses.validations.address.required'),
            'address.address.string' => __('user::frontend.addresses.validations.address.string'),
            'address.address.min' => __('user::frontend.addresses.validations.address.min'),
            'address.block.required' => __('user::frontend.addresses.validations.block.required'),
            'address.block.string' => __('user::frontend.addresses.validations.block.string'),
            'address.street.required' => __('user::frontend.addresses.validations.street.required'),
            'address.street.string' => __('user::frontend.addresses.validations.street.string'),
            'address.building.required' => __('user::frontend.addresses.validations.building.required'),
            'address.building.string' => __('user::frontend.addresses.validations.building.string'),
            'address.avenue.required' => __('user::frontend.addresses.validations.avenue.required'),
            'address.avenue.string' => __('user::frontend.addresses.validations.avenue.string'),
            'address.avenue.max' => __('user::frontend.addresses.validations.avenue.max') . '191',
            'address.floor.required' => __('user::frontend.addresses.validations.floor.required'),
            'address.floor.string' => __('user::frontend.addresses.validations.floor.string'),
            'address.floor.max' => __('user::frontend.addresses.validations.floor.max') . '191',
            'address.flat.required' => __('user::frontend.addresses.validations.flat.required'),
            'address.flat.string' => __('user::frontend.addresses.validations.flat.string'),
            'address.flat.max' => __('user::frontend.addresses.validations.flat.max') . '191',
            'address.automated_number.required' => __('user::frontend.addresses.validations.automated_number.required'),
            'address.automated_number.string' => __('user::frontend.addresses.validations.automated_number.string'),
            'address.automated_number.max' => __('user::frontend.addresses.validations.automated_number.max') . '191',
        ];

        return $v;
    }
}
