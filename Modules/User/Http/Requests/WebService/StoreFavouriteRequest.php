<?php

namespace Modules\User\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavouriteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case 'post':
            case 'POST':
                return [
                    'product_id' => 'required|exists:products,id',
                ];
        }
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'product_id.required' => __('user::api.favourites.validation.product_id.required'),
            'product_id.exists' => __('user::api.favourites.validation.product_id.exists'),
        ];

        return $v;
    }
}
