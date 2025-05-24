<?php

namespace Modules\User\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Rule\WebService\OldPasswordRule;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'current_password'  => ['required' , new OldPasswordRule],
                    'password'          => 'required|min:6|same:password_confirmation',
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
            'password.required'         => __('user::api.users.validation.password.required'),
            'password.min'              => __('user::api.users.validation.password.min'),
            'password.same'             => __('user::api.users.validation.password.same'),
        ];

        return $v;
    }

}
