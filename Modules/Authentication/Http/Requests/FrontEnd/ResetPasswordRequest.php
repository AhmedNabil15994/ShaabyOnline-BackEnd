<?php

namespace Modules\Authentication\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|exists:users,email',
            'token'     => 'required|exists:password_resets,token',
            'password'  => 'required|confirmed|min:6',
        ];
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
            'token.required'      =>   __('authentication::frontend.reset.validation.token.required'),
            'token.exists'        =>   __('authentication::frontend.reset.validation.token.exists'),
            'email.required'      =>   __('authentication::frontend.reset.validation.email.required'),
            'email.email'         =>   __('authentication::frontend.reset.validation.email.email'),
            'email.exists'        =>   __('authentication::frontend.reset.validation.email.exists'),
            'password.required'   =>   __('authentication::frontend.reset.validation.password.required'),
            'password.min'        =>   __('authentication::frontend.reset.validation.password.min'),
        ];

        return $v;
    }
}
