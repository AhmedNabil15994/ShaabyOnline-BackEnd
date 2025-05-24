<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class updatePhotoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'image' => 'required|image|max:2048',
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
    
            'image.required' => __('catalog::dashboard.products.validation.image.required'),
            'image.image' => __('catalog::dashboard.products.validation.image.image'),
            'image.mimes' => __('catalog::dashboard.products.validation.image.mimes'),
            'image.max' => __('catalog::dashboard.products.validation.image.max'),
        ];

        return $v;
    }
}
