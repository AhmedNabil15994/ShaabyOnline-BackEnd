<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'name' => 'required',
                    'mobile' => 'nullable|numeric|unique:users,mobile',
                    //                  'mobile'          => 'required|numeric|unique:users,mobile|digits_between:8,8',
                    'email' => 'nullable|unique:users,email',
                    'password' => 'required|min:6|same:confirm_password',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];
                if (empty($this->email) && empty($this->mobile)) {
                    $rules['email_or_mobile'] = 'required';
                }
                return $rules;

                //handle updates
            case 'put':
            case 'PUT':
                $rules = [
                    'name' => 'required',
                    'mobile' => 'nullable|numeric|unique:users,mobile,' . $this->id . '',
                    //                    'mobile'          => 'required|numeric|digits_between:8,8|unique:users,mobile,'.$this->id.'',
                    'email' => 'nullable|unique:users,email,' . $this->id . '',
                    'password' => 'nullable|min:6|same:confirm_password',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];
                if (empty($this->email) && empty($this->mobile)) {
                    $rules['email_or_mobile'] = 'required';
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
            'name.required' => __('user::dashboard.users.validation.name.required'),
            'email.required' => __('user::dashboard.users.validation.email.required'),
            'email.unique' => __('user::dashboard.users.validation.email.unique'),
            'mobile.required' => __('user::dashboard.users.validation.mobile.required'),
            'mobile.unique' => __('user::dashboard.users.validation.mobile.unique'),
            'mobile.numeric' => __('user::dashboard.users.validation.mobile.numeric'),
            'mobile.digits_between' => __('user::dashboard.users.validation.mobile.digits_between'),
            'password.required' => __('user::dashboard.users.validation.password.required'),
            'password.min' => __('user::dashboard.users.validation.password.min'),
            'password.same' => __('user::dashboard.users.validation.password.same'),

            'email_or_mobile.required' => __('authentication::api.register.validation.email_or_mobile.required'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        return $v;
    }
}
