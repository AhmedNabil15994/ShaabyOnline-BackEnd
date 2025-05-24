<?php

namespace Modules\Vendor\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
                  'image'           => 'required',
                  'code'            => 'required|unique:payments,code',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'code'            => 'required|unique:payments,code,'.$this->id.'',
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
            'image.required'        => __('vendor::dashboard.payments.validation.image.required'),
            'code.required'         => __('vendor::dashboard.payments.validation.code.required'),
            'code.unique'           => __('vendor::dashboard.payments.validation.code.unique'),
        ];

        return $v;

    }
}
