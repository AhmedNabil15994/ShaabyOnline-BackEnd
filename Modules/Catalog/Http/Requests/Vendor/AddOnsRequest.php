<?php

namespace Modules\Catalog\Http\Requests\Vendor;

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
            // handle creates
            case 'post':
            case 'POST':
                $rules = [
                    'option_name.*' => 'required',
                    'add_ons_type' => 'required|in:single,multi',
                    'price' => 'required|array',
                    'rowId' => 'required|array',
                    'option' => 'required|array|min:1',
                    'option' => 'required|array|min:1',
                    "option.*.ar"=>"required",
                    "option.*.en"=>"required",
                    "price.*"    => "required|numeric"

                ];

                /*foreach ($this->option as $key => $value) {
                    foreach ($value as $locale => $v) {
                        $rules["option." . $key . '.' . $locale] = "required";
                    }
                }*/

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
            'add_ons_type.required' => __('catalog::dashboard.products.validation.add_ons.add_ons_type.required'),
            'add_ons_type.in' => __('catalog::dashboard.products.validation.add_ons.add_ons_type.in'),
            'price.required' => __('catalog::dashboard.products.validation.add_ons.price.required'),
            'price.array' => __('catalog::dashboard.products.validation.add_ons.price.array'),
            'rowId.required' => __('catalog::dashboard.products.validation.add_ons.rowId.required'),
            'rowId.array' => __('catalog::dashboard.products.validation.add_ons.rowId.array'),
            'option.array' => __('catalog::dashboard.products.validation.add_ons.option.array'),
            'option.min' => __('catalog::dashboard.products.validation.add_ons.option.min'),
        ];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["option_name." . $key . ".required"] = __('catalog::dashboard.products.validation.add_ons.option_name.required') . ' - ' . $value['native'] . '';
        }

        /*foreach ($this->option as $key => $value) {
            foreach ($value as $locale => $v) {
                $v["option." . $key . '.' . $locale . ".required"] = __('catalog::dashboard.products.validation.add_ons.option.required') . ' - ' . $key . '-' . $locale . '';
            }
        }*/

        return $v;
    }
}
