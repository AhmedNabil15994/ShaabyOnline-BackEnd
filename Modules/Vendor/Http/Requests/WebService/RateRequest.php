<?php

namespace Modules\Vendor\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class RateRequest extends FormRequest
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
                  'order_id'           => 'required|exists:orders,id',
                  'rating'             => 'required|integer|between:1,5',
                  'comment'            => 'nullable|string|max:1000',
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
            'order_id.required'     => __('vendor::webservice.rates.validation.order_id.required'),
            'order_id.exists'       => __('vendor::webservice.rates.validation.order_id.exists'),
            'rating.required'       => __('vendor::webservice.rates.validation.rating.required'),
            'rating.integer'        => __('vendor::webservice.rates.validation.rating.integer'),
            'rating.between'        => __('vendor::webservice.rates.validation.rating.between'),
            'comment.string'        => __('vendor::webservice.rates.validation.comment.string'),
            'comment.max'           => __('vendor::webservice.rates.validation.comment.max'),
        ];

        return $v;

    }
}
