<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AddonOptionRequest extends FormRequest
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

                $rules = [
                    'title.*' => 'required|unique_translation:addon_options,title',
                    'addon_category_id' => 'required|exists:addon_categories,id',
                    'price' => 'required|numeric|min:0',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                if ($this->manage_qty == 'limited')
                    $rules['qty'] = 'required|integer|min:0';

                return $rules;

            //handle updates
            case 'put':
            case 'PUT':

                $rules = [
                    'title.*' => 'required|unique_translation:addon_options,title,' . $this->id,
                    'addon_category_id' => 'required|exists:addon_categories,id',
                    'price' => 'required|numeric|min:0',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                if ($this->manage_qty == 'limited')
                    $rules['qty'] = 'required|integer|min:0';

                return $rules;
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
            // 'image.required' => __('catalog::dashboard.categories.validation.image.required'),
            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('catalog::dashboard.addon_options.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"] = __('catalog::dashboard.addon_options.validation.title.unique') . ' - ' . $value['native'] . '';
        }

        $v['addon_category_id.required'] = __('catalog::dashboard.addon_options.validation.addon_category_id.required');
        $v['addon_category_id.exists'] = __('catalog::dashboard.addon_options.validation.addon_category_id.exists');

        $v['price.required'] = __('catalog::dashboard.addon_options.validation.price.required');
        $v['price.numeric'] = __('catalog::dashboard.addon_options.validation.price.numeric');
        $v['price.min'] = __('catalog::dashboard.addon_options.validation.price.min');

        $v['qty.required'] = __('catalog::dashboard.addon_options.validation.qty.required');
        $v['qty.integer'] = __('catalog::dashboard.addon_options.validation.qty.integer');
        $v['qty.numeric'] = __('catalog::dashboard.addon_options.validation.qty.numeric');
        $v['qty.min'] = __('catalog::dashboard.addon_options.validation.qty.min');

        return $v;
    }
}
