<?php

namespace Modules\Vendor\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
                    // 'title.*' => 'required',
                    'title.*' => 'required|unique_translation:sections,title',
                    'description.*' => 'nullable',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    // 'title.*' => 'required',
                    'title.*' => 'required|unique_translation:sections,title,' . $this->id,
                    'description.*' => 'nullable',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
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
            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('vendor::dashboard.sections.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"] = __('vendor::dashboard.sections.validation.title.unique') . ' - ' . $value['native'] . '';
            $v["description." . $key . ".required"] = __('vendor::dashboard.sections.validation.description.required') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}
