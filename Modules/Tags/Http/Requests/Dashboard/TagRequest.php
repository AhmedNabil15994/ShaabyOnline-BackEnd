<?php

namespace Modules\Tags\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        $rules = [
            'title.*' => 'required',
            'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
        ];

        switch ($this->getMethod()) {

            // handle creates
            case 'post':
            case 'POST':
                return $rules;
            //handle updates
            case 'put':
            case 'PUT':
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
            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v['title.' . $key . '.required'] = __('tags::dashboard.tags.validation.title.required') . ' - ' . $value['native'] . '';
        }
        return $v;

    }
}
