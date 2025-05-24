<?php

namespace Modules\Area\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
                    'city_id'         => 'required',
                    'title.*'         => 'required',
                    'title.*'         => 'required|unique_translation:states,title',
                ];

                // handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'         => 'required',
                    'title.*'         => 'required|unique_translation:states,title,' . $this->id,
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
            'city_id.required'        => __('area::dashboard.states.validation.city_id.required'),
        ];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"]  = __('area::dashboard.states.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"]    = __('area::dashboard.states.validation.title.unique') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}
