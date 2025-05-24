<?php

namespace Modules\Authentication\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email',
            'password'  => 'required|min:6',
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
            'email.required'      =>   __('authentication::driver.login.validations.email.required'),
            'email.email'         =>   __('authentication::driver.login.validations.email.email'),
            'password.required'   =>   __('authentication::driver.login.validations.password.required'),
            'password.min'        =>   __('authentication::driver.login.validations.password.min'),
        ];

        return $v;
    }
}
