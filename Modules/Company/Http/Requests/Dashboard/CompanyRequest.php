<?php

namespace Modules\Company\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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

                $result = [
                    'name.*' => 'required',
                    'manager_name' => 'nullable|string',
                    'email' => 'nullable|unique:companies,email',
                    'password' => 'nullable|min:6|same:confirm_password',
                    'calling_code' => 'nullable',
                    'mobile' => 'nullable|numeric|unique:companies,mobile',
                    // 'mobile' => 'nullable|numeric|unique:companies,mobile|digits_between:8,8',
                    // 'days_status' => 'required|array|min:1',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                if (config('setting.other.select_shipping_provider') == 'shipping_company') {
                    $result['delivery_time_types'] = 'required|array|min:1|in:direct,schedule';
                }

                /* if (isset($this->days_status) && !empty($this->days_status)) {
                    foreach ($this->days_status as $k => $dayCode) {
                        if (array_key_exists($dayCode, $this->is_full_day)) {
                            if ($this->is_full_day[$dayCode] == '0') {

                                if ($this->arrayContainsDuplicate($this->availability['time_from'][$dayCode]) && $this->arrayContainsDuplicate($this->availability['time_to'][$dayCode])) {
                                    $result['availability.duplicated_time.' . $dayCode] = 'required';
                                }

                                foreach ($this->availability['time_from'][$dayCode] as $key => $time) {

                                    if (strtotime($this->availability['time_to'][$dayCode][$key]) < strtotime($time)) {
                                        $result['availability.time.' . $dayCode . '.' . $key] = 'required';
                                    }
                                }
                            }
                        }
                    }
                } */

                return $result;

                //handle updates
            case
            'put':
            case 'PUT':

                $res = [
                    'name.*' => 'required',
                    'manager_name' => 'nullable|string',
                    'email' => 'nullable|unique:companies,email,' . $this->id . '',
                    'password' => 'nullable|min:6|same:confirm_password',
                    'calling_code' => 'nullable',
                    'mobile' => 'nullable|numeric|unique:companies,mobile,' . $this->id . '',
                    // 'mobile' => 'nullable|numeric|digits_between:8,8|unique:companies,mobile,' . $this->id . '',
                    // 'days_status' => 'required|array|min:1',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                if (config('setting.other.select_shipping_provider') == 'shipping_company') {
                    $res['delivery_time_types'] = 'required|array|min:1|in:direct,schedule';
                }

                /* if (isset($this->days_status) && !empty($this->days_status)) {
                    foreach ($this->days_status as $k => $dayCode) {
                        if (array_key_exists($dayCode, $this->is_full_day)) {
                            if ($this->is_full_day[$dayCode] == '0') {

                                if ($this->arrayContainsDuplicate($this->availability['time_from'][$dayCode]) && $this->arrayContainsDuplicate($this->availability['time_to'][$dayCode])) {
                                    $res['availability.duplicated_time.' . $dayCode] = 'required';
                                }

                                foreach ($this->availability['time_from'][$dayCode] as $key => $time) {

                                    if (strtotime($this->availability['time_to'][$dayCode][$key]) < strtotime($time)) {
                                        $res['availability.time.' . $dayCode . '.' . $key] = 'required';
                                    }
                                }
                            }
                        }
                    }
                } */

                return $res;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public
    function authorize()
    {
        return true;
    }

    public
    function messages()
    {
        $v = [
            'email.unique' => __('company::dashboard.companies.validation.email.unique'),
            'mobile.unique' => __('company::dashboard.companies.validation.mobile.unique'),
            'mobile.numeric' => __('company::dashboard.companies.validation.mobile.numeric'),
            'mobile.digits_between' => __('company::dashboard.companies.validation.mobile.digits_between'),
            'password.min' => __('company::dashboard.companies.validation.password.min'),
            'password.same' => __('company::dashboard.companies.validation.password.same'),
            'days_status.required' => __('company::dashboard.companies.validation.days_status.required'),
            'days_status.array' => __('company::dashboard.companies.validation.days_status.array'),
            'days_status.min' => __('company::dashboard.companies.validation.days_status.min'),


            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v['name.' . $key . '.required'] = __('company::dashboard.companies.validation.name.required') . ' - ' . $value['native'] . '';
        }

        /* if (isset($this->days_status) && !empty($this->days_status)) {
            foreach ($this->days_status as $k => $dayCode) {
                if (array_key_exists($dayCode, $this->is_full_day)) {
                    if ($this->is_full_day[$dayCode] == '0') {

                        $duplicatedMsg = __('company::dashboard.companies.availabilities.form.day');
                        $duplicatedMsg .= ' " ' . __('company::dashboard.companies.availabilities.days.' . $dayCode) . ' " ';
                        $duplicatedMsg .= __('company::dashboard.companies.availabilities.form.contain_duplicated_values');
                        $v['availability.duplicated_time.' . $dayCode . '.required'] = $duplicatedMsg;

                        foreach ($this->availability['time_from'][$dayCode] as $key => $time) {

                            if (strtotime($this->availability['time_to'][$dayCode][$key]) < strtotime($time)) {
                                $requiredMsg = __('company::dashboard.companies.availabilities.form.time');
                                $requiredMsg .= ' " ' . $time . ' " ';
                                $requiredMsg .= __('company::dashboard.companies.availabilities.form.for_day');
                                $requiredMsg .= ' " ' . __('company::dashboard.companies.availabilities.days.' . $dayCode) . ' " ';
                                $requiredMsg .= " " . __('company::dashboard.companies.availabilities.form.greater_than') . " ";
                                $requiredMsg .= " " . __('company::dashboard.companies.availabilities.form.time') . " ";
                                $requiredMsg .= ' " ' . $this->availability['time_to'][$dayCode][$key] . ' " ';

                                $v['availability.time.' . $dayCode . '.' . $key . '.required'] = $requiredMsg;
                            }
                        }
                    }
                }
            }
        } */

        return $v;
    }

    /* public function arrayContainsDuplicate($array)
    {
        return count($array) != count(array_unique($array));
    } */
}
