<?php

namespace Modules\Catalog\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class SelectAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address'     => 'required|numeric',
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

        $v = [
          'address.required'       => __('catalog::frontend.address.validation.address.required'),
          'address.numeric'        => __('catalog::frontend.address.validation.address.numeric'),
        ];

        return $v;
    }
}
