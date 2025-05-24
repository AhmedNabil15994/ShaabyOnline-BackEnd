<?php

namespace Modules\User\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            //handle updates
            case 'put':
            case 'PUT':
                $rules = [
                    'name' => 'required',
                    'mobile' => 'nullable|numeric|unique:users,mobile,' . auth('api')->id() . '',
//                    'mobile' => 'required|numeric|digits_between:8,8|unique:users,mobile,'.auth()->id().'',
                    'email' => 'nullable|unique:users,email,' . auth('api')->id() . '',
                    'password' => 'nullable|min:6|same:password_confirmation',
                ];

                if (empty($this->email) && empty($this->mobile)) {
                    $rules['email_or_mobile'] = 'required';
                }

                /*if (!empty($this->mobile)) {
                    $rules['firebase_id'] = 'nullable|unique:users,firebase_id';
                }*/
                return $rules;
        }
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'name.required' => __('user::api.users.validation.name.required'),
            'email.required' => __('user::api.users.validation.email.required'),
            'email.unique' => __('user::api.users.validation.email.unique'),
            'mobile.required' => __('user::api.users.validation.mobile.required'),
            'mobile.unique' => __('user::api.users.validation.mobile.unique'),
            'mobile.numeric' => __('user::api.users.validation.mobile.numeric'),
            'mobile.digits_between' => __('user::api.users.validation.mobile.digits_between'),
            'password.required' => __('user::api.users.validation.password.required'),
            'password.min' => __('user::api.users.validation.password.min'),
            'password.same' => __('user::api.users.validation.password.same'),

            'email_or_mobile.required' => __('authentication::api.register.validation.email_or_mobile.required'),
            'firebase_id.required' => __('authentication::api.register.validation.firebase_id.required'),
            'firebase_id.unique' => __('authentication::api.register.validation.firebase_id.unique'),
        ];

        return $v;
    }
}
