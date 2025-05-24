<?php

namespace Modules\User\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class UserFirebaseTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        $rules = [];
        switch ($this->getMethod()) {
            //handle updates
            case 'post':
            case 'POST':
                $rules = [
                    'firebase_token' => 'required|string',
                    'device_type' => 'required|integer|in:1,2,3', // 1 => andriod, 2 => ios, 3 => web
                ];
        }
        return $rules;
    }

    public function messages()
    {
        $v = [
            'firebase_token.required' => __('user::api.users.validation.firebase_token.required'),
            'firebase_token.string' => __('user::api.users.validation.firebase_token.string'),
            'device_type.required' => __('user::api.users.validation.device_type.required'),
            'device_type.integer' => __('user::api.users.validation.device_type.integer'),
            'device_type.in' => __('user::api.users.validation.device_type.in'),
        ];

        return $v;
    }
}
