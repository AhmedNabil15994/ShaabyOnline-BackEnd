<?php

namespace Modules\Subscription\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
                  'vendor_id'          => 'required',
                  'package_id'         => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                  'end_at'        => 'required',
                  'total'         => 'required',
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
            'vendor_id.required'      => __('subscription::dashboard.subscriptions.validation.vendor_id.required'),
            'package_id.required'     => __('subscription::dashboard.subscriptions.validation.package_id.required'),
            'end_at.required'         => __('subscription::dashboard.subscriptions.validation.end_at.required'),
            'total.required'          => __('subscription::dashboard.subscriptions.validation.total.required'),
        ];

        return $v;

    }
}
