<?php

namespace Modules\Setting\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'email' => 'required|email|exists:users,email',
            'default_vendor' => 'required_if:other.is_multi_vendors,==,0',
            'other.shipping_company' => 'required'
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
            'email.required'      =>   __('setting::dashboard.password.email.required'),
            'email.email'         =>   __('setting::dashboard.password.email.email'),
            'email.exists'        =>   __('setting::dashboard.password.email.exists'),
            'default_vendor.required_if'                 =>   __('setting::dashboard.settings.form.default_vendor_validation.required_if'),
            'other.shipping_company.required'            =>   __('setting::dashboard.settings.form.validation.other.shipping_company.required'),
        ];

        return $v;
    }
}
