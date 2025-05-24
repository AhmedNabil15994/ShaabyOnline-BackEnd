<?php

namespace Modules\Authentication\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ForgetPasswordForMobileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'calling_code' => 'nullable|numeric',
            'mobile' => ['required', 'numeric', 'digits_between:3,20', Rule::exists("users", "mobile")->where(function ($query) {
                $query->where("calling_code", $this->calling_code ?? '965');
            })],
//            'mobile' => 'required|exists:users,mobile|numeric',
//            'firebase_id' => 'required|exists:users,firebase_id',
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
            'calling_code.required' => __('authentication::api.forget_password.validation.calling_code.required'),
            'calling_code.numeric' => __('authentication::api.forget_password.validation.calling_code.numeric'),
            'calling_code.max' => __('authentication::api.forget_password.validation.calling_code.max'),
            'mobile.required' => __('authentication::api.forget_password.validation.mobile.required'),
            'mobile.unique' => __('authentication::api.forget_password.validation.mobile.unique'),
            'mobile.numeric' => __('authentication::api.forget_password.validation.mobile.numeric'),
            'mobile.digits_between' => __('authentication::api.forget_password.validation.mobile.digits_between'),
            'mobile.exists' => __('authentication::api.forget_password.validation.mobile.exists'),
            'firebase_id.required' => __('authentication::api.forget_password.validation.firebase_id.required'),
            'firebase_id.exists' => __('authentication::api.forget_password.validation.firebase_id.exists'),
        ];
        return $v;
    }
}
