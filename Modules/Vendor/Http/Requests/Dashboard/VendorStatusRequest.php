<?php

namespace Modules\Vendor\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class VendorStatusRequest extends FormRequest
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
                  'label_color'       => 'required',
                  // 'accepted_orders'   => 'unique:vendor_statuses,accepted_orders'
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'label_color'       => 'required',
                    // 'accepted_orders'   => 'unique:vendor_statuses,accepted_orders'
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
            'label_color.required'        => __('vendor::dashboard.vendor_statuses.validation.label_color.required'),
            'accepted_orders.required'         => __('vendor::dashboard.vendor_statuses.validation.accepted_orders.required'),
            'accepted_orders.unique'           => __('vendor::dashboard.vendor_statuses.validation.code.unique'),
        ];

        return $v;

    }
}
