<?php

namespace Modules\Advertising\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisingGroupRequest extends FormRequest
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
                    'position' => 'nullable|in:home,categories',
                    'title.*' => 'required',
                ];
            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'position' => 'nullable|in:home,categories',
                    'title.*' => 'required',
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
            'position.required' => __('advertising::dashboard.advertising_groups.validation.position.required'),
            'position.in' => __('advertising::dashboard.advertising_groups.validation.position.in'),
        ];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v['title.' . $key . '.required'] = __('advertising::dashboard.advertising_groups.validation.title.required') . ' - ' . $value['native'] . '';
        }
        return $v;

    }
}
