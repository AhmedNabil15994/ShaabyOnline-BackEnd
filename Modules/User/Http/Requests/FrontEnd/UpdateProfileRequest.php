<?php

namespace Modules\User\Http\Requests\FrontEnd;

use Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
//            'country_code'       => 'required|string|bail|size:2',
//            'mobile'             => ['required', 'unique:users,mobile,'.auth()->id(), 'phone:'.request('country_code')],
//            'mobile'             => ['required', 'unique:users,mobile,'.auth()->id()],
            'mobile' => ['required', 'unique:users,mobile,' . auth()->id(), 'digits:8'],
            'email' => 'required|email|max:191|unique:users,email,' . auth()->id(),
            'current_password' => 'required_with:password|max:191',
            'password' => 'nullable|required_with:current_password|confirmed|min:6|max:191',
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
        return [
            'name.required' => __('user::frontend.profile.index.validation.name.required'),
            'mobile.required' => __('user::frontend.profile.index.validation.mobile.required'),
            'mobile.unique' => __('user::frontend.profile.index.validation.mobile.unique'),
            'mobile.phone' => __('authentication::frontend.register.validation.mobile.phone'),
            'mobile.digits' => __('authentication::frontend.register.validation.mobile.digits'),
            'email.required' => __('user::frontend.profile.index.validation.email.required'),
            'email.unique' => __('user::frontend.profile.index.validation.email.unique'),
            'email.email' => __('user::frontend.profile.index.validation.email.email'),
            'password.required' => __('user::frontend.profile.index.validation.password.required'),
            'password.min' => __('user::frontend.profile.index.validation.password.min'),
            'password.confirmed' => __('user::frontend.profile.index.validation.password.confirmed'),
            'password.required_with' => __('user::frontend.profile.index.validation.password.required_with'),
            'current_password.required_with' => __('user::frontend.profile.index.validation.current_password.required_with'),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->current_password != null) {
                if (!Hash::check($this->current_password, $this->user()->password)) {
                    $validator->errors()->add(
                        'current_password', __('user::frontend.profile.index.validation.current_password.not_match')
                    );
                }
            }
        });
    }
}
