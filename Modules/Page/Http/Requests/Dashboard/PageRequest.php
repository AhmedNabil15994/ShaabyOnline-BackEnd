<?php

namespace Modules\Page\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
                    'title.*'         => 'required|unique_translation:pages,title',
                    'description.*'   => 'required',
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'          => 'required|unique_translation:pages,title,' . $this->id,
                    'description.*'    => 'required',
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
            $v["title." . $key . ".required"]  = __('page::dashboard.pages.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"]    = __('page::dashboard.pages.validation.title.unique') . ' - ' . $value['native'] . '';
            $v["description." . $key . ".required"]  = __('page::dashboard.pages.validation.description.required') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}
