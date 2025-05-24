<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AddOnsRequest extends FormRequest
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
                    'addon_category_id' => 'required|exists:addon_categories,id',
                    'add_ons_type' => 'required|in:single,multi',
                    'addon_options' => 'required|array|min:1',
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
            'add_ons_type.required' => __('catalog::dashboard.products.validation.add_ons.add_ons_type.required'),
            'add_ons_type.in' => __('catalog::dashboard.products.validation.add_ons.add_ons_type.in'),
            'addon_category_id.required' => __('catalog::dashboard.addon_options.validation.addon_category_id.required'),
            'addon_category_id.exists' => __('catalog::dashboard.addon_options.validation.addon_category_id.exists'),
            'addon_options.required' => __('catalog::dashboard.addon_options.validation.addon_options.required'),
            'addon_options.array' => __('catalog::dashboard.addon_options.validation.addon_options.array'),
            'addon_options.min' => __('catalog::dashboard.addon_options.validation.addon_options.min'),
        ];
        return $v;
    }
}
