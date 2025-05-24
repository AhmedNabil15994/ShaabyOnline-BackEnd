<?php

namespace Modules\Subscription\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                  'months'          => 'required',
                  'price'           => 'required|numeric',
                  'special_price'   => 'nullable|numeric',
//                  'title.*'         => 'required',
                  'title.*'         => 'required|unique:package_translations,title',
                  'description.*'   => 'nullable',
                  'seo_description.*'   => 'nullable',
                  'seo_keywords.*'      => 'nullable',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'months'           => 'required|numeric',
                    'price'            => 'required|numeric',
                    'special_price'    => 'nullable|numeric',
                    'title.*'          => 'required',
//                    'title.*'          => 'required|unique:package_translations,title,'.$this->id.',package_id',
                    'description.*'    => 'nullable',
                    'seo_description.*'   => 'nullable',
                    'seo_keywords.*'      => 'nullable',
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
            'months.required'         => __('subscription::dashboard.packages.validation.months.required'),
            'months.numeric'          => __('subscription::dashboard.packages.validation.months.numeric'),
            'price.required'          => __('subscription::dashboard.packages.validation.price.required'),
            'price.numeric'           => __('subscription::dashboard.packages.validation.price.numeric'),
            'special_price.numeric'   => __('subscription::dashboard.packages.validation.special_price.numeric'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {

          $v["title.".$key.".required"]        = __('subscription::dashboard.packages.validation.title.required').' - '.$value['native'].'';

          $v["title.".$key.".unique"]          = __('subscription::dashboard.packages.validation.title.unique').' - '.$value['native'].'';

          $v["description.".$key.".required"]  = __('subscription::dashboard.packages.validation.description.required').' - '.$value['native'].'';

        }

        return $v;

    }
}
