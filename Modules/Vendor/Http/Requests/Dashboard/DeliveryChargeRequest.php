<?php

namespace Modules\Vendor\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryChargeRequest extends FormRequest
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

                $rules = [
                    'delivery' => 'required|array',
                    //                    'delivery.*' => 'required', //ensures its not null
                    'state' => 'required|array',
                    // 'delivery_time' => 'nullable|array',
                    //                  'company'      => 'required|numeric',
                ];

                if (isset($this->days_status) && !empty($this->days_status) && config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                    $workTimesRoles = $this->workTimesValidation($this->days_status, $this->is_full_day, $this->availability);
                    $rules = array_merge($rules, $workTimesRoles);
                }
                return $rules;

            //handle updates
            case 'put':
            case 'PUT':
                $rules = [
                    'delivery' => 'required|array',
                    //                    'delivery.*' => 'required', //ensures its not null
                    'state' => 'required|array',
                    // 'delivery_time' => 'nullable|array',
                    //                  'company'   => 'required|numeric',
                ];

                if (isset($this->days_status) && !empty($this->days_status) && config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                    $workTimesRoles = $this->workTimesValidation($this->days_status, $this->is_full_day, $this->availability);
                    $rules = array_merge($rules, $workTimesRoles);
                }
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
            'delivery.required' => __('company::dashboard.delivery_charges.validation.delivery.required'),
            'delivery.*.required' => __('company::dashboard.delivery_charges.validation.delivery.required'),
            'delivery.array' => __('company::dashboard.delivery_charges.validation.delivery.array'),
            'state.required' => __('company::dashboard.delivery_charges.validation.state.required'),
            'state.array' => __('company::dashboard.delivery_charges.validation.state.array'),
        ];

        if (isset($this->days_status) && !empty($this->days_status) && config('setting.other.select_shipping_provider') == 'vendor_delivery') {
            $workTimesRoles = $this->workTimesValidationMessages($this->days_status, $this->is_full_day, $this->availability);
            $v = array_merge($v, $workTimesRoles);
        }

        return $v;
    }

    private function workTimesValidation($days_status, $is_full_day, $availability)
    {
        $roles = [];
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '0') {
                    if ($this->arrayContainsDuplicate($availability['time_from'][$dayCode]) && $this->arrayContainsDuplicate($availability['time_to'][$dayCode])) {
                        $roles['availability.duplicated_time.' . $dayCode] = 'required';
                    }
                    foreach ($availability['time_from'][$dayCode] as $key => $time) {
                        if (strtotime($availability['time_to'][$dayCode][$key]) < strtotime($time)) {
                            $roles['availability.time.' . $dayCode . '.' . $key] = 'required';
                        }
                    }
                }
            }
        }

        return $roles;
    }

    private function workTimesValidationMessages($days_status, $is_full_day, $availability)
    {
        $v = [];
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '0') {

                    $duplicatedMsg = __('vendor::dashboard.vendors.availabilities.form.day');
                    $duplicatedMsg .= ' " ' . __('vendor::dashboard.vendors.availabilities.days.' . $dayCode) . ' " ';
                    $duplicatedMsg .= __('vendor::dashboard.vendors.availabilities.form.contain_duplicated_values');
                    $v['availability.duplicated_time.' . $dayCode . '.required'] = $duplicatedMsg;

                    foreach ($availability['time_from'][$dayCode] as $key => $time) {

                        if (strtotime($availability['time_to'][$dayCode][$key]) < strtotime($time)) {
                            $requiredMsg = __('vendor::dashboard.vendors.availabilities.form.time');
                            $requiredMsg .= ' " ' . $time . ' " ';
                            $requiredMsg .= __('vendor::dashboard.vendors.availabilities.form.for_day');
                            $requiredMsg .= ' " ' . __('vendor::dashboard.vendors.availabilities.days.' . $dayCode) . ' " ';
                            $requiredMsg .= " " . __('vendor::dashboard.vendors.availabilities.form.greater_than') . " ";
                            $requiredMsg .= " " . __('vendor::dashboard.vendors.availabilities.form.time') . " ";
                            $requiredMsg .= ' " ' . $availability['time_to'][$dayCode][$key] . ' " ';

                            $v['availability.time.' . $dayCode . '.' . $key . '.required'] = $requiredMsg;
                        }
                    }
                }
            }
        }
        return $v;
    }

    public function arrayContainsDuplicate($array)
    {
        return count($array) != count(array_unique($array));
    }
}
