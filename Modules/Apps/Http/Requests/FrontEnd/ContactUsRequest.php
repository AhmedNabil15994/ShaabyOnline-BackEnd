<?php

namespace Modules\Apps\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

            return [
              'username'            => 'required|string|min:3',
              'mobile'              => 'required|numeric',
//              'mobile'              => 'required|numeric|digits_between:8,8',
              'email'               => 'required|email',
              'message'             => 'required|string|min:10',
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
            'username.required'           =>   __('apps::frontend.contact_us.validations.username.required'),
            'username.string'             =>   __('apps::frontend.contact_us.validations.username.string'),
            'username.min'                =>   __('apps::frontend.contact_us.validations.username.min'),
            'mobile.required'             =>   __('apps::frontend.contact_us.validations.mobile.required'),
            'mobile.numeric'              =>   __('apps::frontend.contact_us.validations.mobile.numeric'),
            'mobile.digits_between'       =>   __('apps::frontend.contact_us.validations.mobile.digits_between'),
            'email.required'              =>   __('apps::frontend.contact_us.validations.email.required'),
            'email.email'                 =>   __('apps::frontend.contact_us.validations.email.email'),
            'message.required'            =>   __('apps::frontend.contact_us.validations.message.required'),
            'message.string'              =>   __('apps::frontend.contact_us.validations.message.string'),
            'message.min'                 =>   __('apps::frontend.contact_us.validations.message.min'),
        ];

        return $v;

    }
}
