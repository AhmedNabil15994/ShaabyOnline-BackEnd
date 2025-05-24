<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
                // handle creates
            case 'post':
            case 'POST':

                $rules = [
                    'roles'           => 'required',
                    'name'            => 'required',
                    'mobile'          => 'required|numeric|unique:users,mobile',
                    //                  'mobile'          => 'required|numeric|unique:users,mobile|digits_between:8,8',
                    'email'           => 'required|unique:users,email',
                    'password'        => 'required|min:6|same:confirm_password',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                if (config('setting.other.select_shipping_provider') == 'shipping_company') {
                    $rules['company_id'] = 'required';
                }
                return $rules;

                //handle updates
            case 'put':
            case 'PUT':
                $rules = [
                    'roles'           => 'required',
                    'name'            => 'required',
                    'mobile'          => 'required|numeric|unique:users,mobile,' . $this->id . '',
                    //                    'mobile'          => 'required|numeric|digits_between:8,8|unique:users,mobile,'.$this->id.'',
                    'email'           => 'required|unique:users,email,' . $this->id . '',
                    'password'        => 'nullable|min:6|same:confirm_password',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                if (config('setting.other.select_shipping_provider') == 'shipping_company') {
                    $rules['company_id'] = 'required';
                }
                return $rules;
        }
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
            'company_id.required'     => __('user::dashboard.drivers.validation.company_id.required'),
            'roles.required'          => __('user::dashboard.drivers.validation.roles.required'),
            'name.required'           => __('user::dashboard.drivers.validation.name.required'),
            'email.required'          => __('user::dashboard.drivers.validation.email.required'),
            'email.unique'            => __('user::dashboard.drivers.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.drivers.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.drivers.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.drivers.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.drivers.validation.mobile.digits_between'),
            'password.required'       => __('user::dashboard.drivers.validation.password.required'),
            'password.min'            => __('user::dashboard.drivers.validation.password.min'),
            'password.same'           => __('user::dashboard.drivers.validation.password.same'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        return $v;
    }
}
