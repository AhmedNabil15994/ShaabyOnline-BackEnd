<?php

namespace Modules\Area\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Area\Entities\Country;

class CountryRequest extends FormRequest
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
                    // 'code' => 'required|string|unique:countries,code',
                    //'title.*' => 'required|unique:country_translations,title',
                    'code' => ['required', Rule::unique('countries')->whereNull('deleted_at')],
                    'title.*' => ['required', Rule::unique('countries', 'title')->where(function ($query) {
                        return $query->where('id', Country::whereNull('deleted_at')->where('code', $this->code)->value('id'));
                    })],
                ];
                //handle updates
            case 'put':
            case 'PUT':
                return [
                    //'code' => 'required|string|unique:countries,code,' . $this->id,
                    //'title.*' => 'required|unique:country_translations,title,' . $this->id . ',country_id',
                    'code' => ['required', Rule::unique('countries')->ignore($this->id)->whereNull('deleted_at')],
                    'title.*' => ['required', Rule::unique('countries', 'title')->ignore($this->id, 'id')->where(function ($query) {
                        return $query->where('id', Country::whereNull('deleted_at')->where('id', $this->id)->value('id'));
                    })],
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
        $v["code.required"] = __('area::dashboard.countries.validation.code.required');
        $v["code.string"] = __('area::dashboard.countries.validation.code.string');
        $v["code.unique"] = __('area::dashboard.countries.validation.code.unique');
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('area::dashboard.countries.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"] = __('area::dashboard.countries.validation.title.unique') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}
