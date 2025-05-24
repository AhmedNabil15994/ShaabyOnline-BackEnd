<?php

namespace Modules\Catalog\Http\Requests\FrontEnd;

use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Variation\Entities\Option;
use Hash;

class CartRequest extends FormRequest
{

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            // handle creates
            case 'get':
            case 'GET':
            case 'post':
            case 'POST':

                return [
//                  'qty'             => 'required|numeric',
                    'qty' => 'numeric|required_unless:request_type,general_cart',
                    'notes' => 'nullable|max:500',
                    'option_value.*' => 'sometimes|required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'qty' => 'numeric|required_unless:request_type,general_cart',
                    'notes' => 'nullable|max:500',
                    'option_value.*' => 'sometimes|required',
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
            'qty.required' => __('catalog::frontend.products.validation.qty.required'),
            'qty.numeric' => __('catalog::frontend.products.validation.qty.numeric'),
            'notes.max' => __('catalog::frontend.products.validation.notes.max'),
        ];

        if (isset($this->option_value)) {
            foreach ($this->option_value as $key => $value) {
                $v["option_value." . $key . ".required"] =
                    __('catalog::frontend.products.validation.option_value.required') . ' ' .
                    strtolower(Option::find($key)->title);
            }
        }

        return $v;

    }
}
