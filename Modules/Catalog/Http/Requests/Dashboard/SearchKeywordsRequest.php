<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SearchKeywordsRequest extends FormRequest
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
                    'title' => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title' => 'required',
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
            'title.required' => __('catalog::dashboard.search_keywords.validation.title.required'),
        ];
        return $v;

    }
}
