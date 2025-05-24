<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class HomeCategoryRequest extends FormRequest
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
            case 'post':
            case 'POST':

                return [
                    'title.*' => 'required|unique_translation:home_categories,title',
                    "sort"    => "required|integer|min:0",
                    "image"   => "nullable|image",
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*' => 'required|unique_translation:home_categories,title,' . $this->id,
                    "sort"    => "required|integer|min:0",
                    "image"   => "nullable|image",
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

            'image.required' => __('catalog::dashboard.categories.validation.image.required'),
        ];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('catalog::dashboard.categories.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"] = __('catalog::dashboard.categories.validation.title.unique') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}
