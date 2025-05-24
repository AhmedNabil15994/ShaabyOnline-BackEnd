<?php

namespace Modules\Order\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OrderDriverRequest extends FormRequest
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
            case 'put':
            case 'PUT':

                return [
                    'user_id' => 'nullable|exists:users,id',
                    'order_status' => 'required|exists:order_statuses,id',
                    'order_notes' => 'nullable',
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
            'user_id.required' => __('order::dashboard.order_drivers.validation.user_id.required'),
            'user_id.exists' => __('order::dashboard.order_drivers.validation.user_id.exists'),
            'order_status.required' => __('order::dashboard.order_drivers.validation.order_status.required'),
            'order_status.exists' => __('order::dashboard.order_drivers.validation.order_status.exists'),
        ];
        return $v;
    }
}
