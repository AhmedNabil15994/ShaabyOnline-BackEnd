<?php

namespace Modules\Variation\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
                    'title.*' => 'required|unique_translation:options,title',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*' => 'required|unique_translation:options,title,' . $this->id ,
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
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('variation::dashboard.options.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"] = __('variation::dashboard.options.validation.title.unique') . ' - ' . $value['native'] . '';
        }
        return $v;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (!empty($this->option_value_title)) {
                foreach (config('laravellocalization.supportedLocales') as $key => $value) {
                    if (isset($this->option_value_title[$key]) && in_array(null, $this->option_value_title[$key], true)) {
                        return $validator->errors()->add(
                            'option_value_title', __('variation::dashboard.option_values.validation.title.required') . ' - ' . $value['native']
                        );
                    }
                }
            } else {
                return $validator->errors()->add(
                    'option_value', __('variation::dashboard.option_values.validation.option_value.required')
                );
            }

        });

        return true;
    }

}
