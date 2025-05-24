<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductPhotoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'images' => 'required|max:300',
            'images.*' => 'image',
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
        return [
            'images.required' => __('catalog::dashboard.products.validation.image.required'),
            'images.*.image' => __('catalog::dashboard.products.validation.image.image'),
        ];
    }
}
