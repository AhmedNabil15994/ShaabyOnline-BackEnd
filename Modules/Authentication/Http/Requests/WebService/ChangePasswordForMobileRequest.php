<?php

namespace Modules\Authentication\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePasswordForMobileRequest extends FormRequest
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
                return [
                    'calling_code' => 'nullable|numeric',
//                    'mobile' => 'required|exists:users,mobile|numeric|digits_between:3,20',
                    'mobile' => ['required', 'numeric', 'digits_between:3,20', Rule::exists("users", "mobile")->where(function ($query) {
                        $query->where("calling_code", $this->calling_code ?? '965');
                    })],
                    'password' => 'required|min:6|same:password_confirmation',
                    "code" => "required",
//                    'firebase_id' => 'required|exists:users,firebase_id',
                ];
        }
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'current_password.required' => __('user::api.users.validation.current_password.required'),
            'password.required' => __('user::api.users.validation.password.required'),
            'password.min' => __('user::api.users.validation.password.min'),
            'password.same' => __('user::api.users.validation.password.same'),
            'firebase_id.required' => __('authentication::api.forget_password.validation.firebase_id.required'),
            'firebase_id.exists' => __('authentication::api.forget_password.validation.firebase_id.exists'),
            'calling_code.required' => __('authentication::api.forget_password.validation.calling_code.required'),
            'calling_code.numeric' => __('authentication::api.forget_password.validation.calling_code.numeric'),
            'calling_code.max' => __('authentication::api.forget_password.validation.calling_code.max'),
            'mobile.required' => __('authentication::api.forget_password.validation.mobile.required'),
            'mobile.unique' => __('authentication::api.forget_password.validation.mobile.unique'),
            'mobile.numeric' => __('authentication::api.forget_password.validation.mobile.numeric'),
            'mobile.digits_between' => __('authentication::api.forget_password.validation.mobile.digits_between'),
            'mobile.exists' => __('authentication::api.forget_password.validation.mobile.exists'),
            'code.required' => __('authentication::api.forget_password.validation.code.required'),
        ];

        return $v;
    }

}
