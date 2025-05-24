<?php

namespace Modules\Authentication\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|string|max:191',
//            'country_code' => 'required|string|bail|size:2',
//            'mobile'     => ['required', 'unique:users,mobile', 'phone:'.request('country_code')],
//            'mobile' => ['required', 'unique:users,mobile', 'max:8'],
            'mobile' => ['nullable', 'unique:users,mobile', 'digits:8'],
            'email' => 'nullable|email|unique:users,email|max:191',
            'password' => 'required|confirmed|min:6|max:191',
        ];

        if (empty($this->email) && empty($this->mobile)) {
            $rules['email_or_mobile'] = 'required';
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
            'name.required' => __('authentication::frontend.register.validation.name.required'),
            'mobile.required' => __('authentication::frontend.register.validation.mobile.required'),
            'mobile.unique' => __('authentication::frontend.register.validation.mobile.unique'),
            'mobile.phone' => __('authentication::frontend.register.validation.mobile.phone'),
            'mobile.digits_between' => __('authentication::frontend.register.validation.mobile.digits_between'),
            'mobile.digits' => __('authentication::frontend.register.validation.mobile.digits'),
            'mobile.max' => __('authentication::frontend.register.validation.mobile.max'),
            'email.required' => __('authentication::frontend.register.validation.email.required'),
            'email.unique' => __('authentication::frontend.register.validation.email.unique'),
            'email.email' => __('authentication::frontend.register.validation.email.email'),
            'password.required' => __('authentication::frontend.register.validation.password.required'),
            'password.min' => __('authentication::frontend.register.validation.password.min'),
            'password.confirmed' => __('authentication::frontend.register.validation.password.confirmed'),

            'email_or_mobile.required' => __('authentication::frontend.register.validation.email_or_mobile.required'),
        ];

        return $v;
    }
}
