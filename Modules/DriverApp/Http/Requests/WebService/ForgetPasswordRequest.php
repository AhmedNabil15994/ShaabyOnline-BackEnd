<?php

namespace Modules\DriverApp\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            'email.required'      =>   __('authentication::api.password.validation.email.required'),
            'email.email'         =>   __('authentication::api.password.validation.email.email'),
            'email.exists'        =>   __('authentication::api.password.validation.email.exists'),
        ];

        return $v;
    }
}
