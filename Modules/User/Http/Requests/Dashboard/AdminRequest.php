<?php

namespace Modules\User\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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

                return [
                    'roles'           => 'required',
                    'name'            => 'required',
                    'mobile'          => 'required|numeric|unique:users,mobile',
                    //                  'mobile'          => 'required|numeric|unique:users,mobile|digits_between:8,8',
                    'email'           => 'required|unique:users,email',
                    'password'        => 'required|min:6|same:confirm_password',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'roles'           => 'required',
                    'name'            => 'required',
                    'mobile'          => 'required|numeric|unique:users,mobile,' . $this->id . '',
                    //                    'mobile'          => 'required|numeric|digits_between:8,8|unique:users,mobile,'.$this->id.'',
                    'email'           => 'required|unique:users,email,' . $this->id . '',
                    'password'        => 'nullable|min:6|same:confirm_password',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];
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
            'roles.required'          => __('user::dashboard.admins.validation.roles.required'),
            'name.required'           => __('user::dashboard.admins.validation.name.required'),
            'email.required'          => __('user::dashboard.admins.validation.email.required'),
            'email.unique'            => __('user::dashboard.admins.validation.email.unique'),
            'mobile.required'         => __('user::dashboard.admins.validation.mobile.required'),
            'mobile.unique'           => __('user::dashboard.admins.validation.mobile.unique'),
            'mobile.numeric'          => __('user::dashboard.admins.validation.mobile.numeric'),
            'mobile.digits_between'   => __('user::dashboard.admins.validation.mobile.digits_between'),
            'password.required'       => __('user::dashboard.admins.validation.password.required'),
            'password.min'            => __('user::dashboard.admins.validation.password.min'),
            'password.same'           => __('user::dashboard.admins.validation.password.same'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        return $v;
    }
}
