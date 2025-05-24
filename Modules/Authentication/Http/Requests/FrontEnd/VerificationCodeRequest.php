<?php

namespace Modules\Authentication\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class VerificationCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'verification_code' => ['required'],
            'mobile' => ['required'/*, 'exists:users,mobile'*/, 'digits:8'],
            'type' => ['nullable'],
        ];
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
            'verification_code.required' => __('authentication::frontend.verification_code.validation.verification_code.required'),
            'mobile.required' => __('authentication::frontend.register.validation.mobile.required'),
            'mobile.unique' => __('authentication::frontend.register.validation.mobile.unique'),
            'mobile.digits' => __('authentication::frontend.register.validation.mobile.digits'),
            'mobile.exists' => __('authentication::frontend.verification_code.validation.mobile.exists'),
        ];
        return $v;
    }
}
