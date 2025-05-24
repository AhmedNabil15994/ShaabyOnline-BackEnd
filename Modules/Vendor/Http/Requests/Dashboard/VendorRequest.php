<?php

namespace Modules\Vendor\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
                    // 'seller_id'       => 'required',
                    'seller_id' => 'nullable',
                    'section_id' => 'nullable|exists:sections,id',
                    'vendor_category_id' => 'nullable',
                    // 'image' => 'required',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    /* 'fixed_commission' => 'nullable|numeric',
                    'commission' => 'required|numeric',
                    'order_limit' => 'required|numeric',
                    'fixed_delivery' => 'required|numeric', */
                    // 'title.*'         => 'required',
                    'title.*' => 'required|unique_translation:vendors,title',
                    'description.*' => 'nullable',
                    /* 'companies' => 'nullable|array|exists:companies,id',
                    'states' => 'nullable|array|exists:states,id', */
                    'address.*' => 'nullable',
                    'mobile' => 'nullable|numeric|unique:vendors,mobile',
                    // 'mobile' => 'nullable|numeric|unique:vendors,mobile|digits_between:8,8',
                ];

                if (config('setting.supported_payments.upayment.account_type') == 'vendor_account') {
                    $rules['payment_data.ibans'] = 'required';
                    $rules['payment_data.fixed_app_commission'] = 'nullable|numeric';
                    $rules['payment_data.percentage_app_commission'] = 'nullable|numeric';
                }

                if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                    $rules['delivery_time_types'] = 'required|array|min:1|in:direct,schedule';
                }

                if (isset($this->days_status) && !empty($this->days_status)) {
                    $workTimesRoles = $this->workTimesValidation($this->days_status, $this->is_full_day, $this->availability);
                    $rules = array_merge($rules, $workTimesRoles);
                }

                return $rules;

            //handle updates
            case 'put':
            case 'PUT':
                $rules = [
                    //                    'seller_id'        => 'required',
                    'seller_id' => 'nullable',
                    'section_id' => 'nullable|exists:sections,id',
                    'vendor_category_id' => 'nullable',
                    /* 'fixed_commission' => 'nullable|numeric',
                    'commission' => 'required|numeric',
                    'order_limit' => 'required|numeric',
                    'fixed_delivery' => 'required|numeric', */
                    //                    'title.*'          => 'required',
                    'title.*' => 'required|unique_translation:vendors,title,' . $this->id,
                    'description.*' => 'nullable',
                    /* 'companies' => 'nullable|array|exists:companies,id',
                    'states' => 'nullable|array|exists:states,id', */
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'address.*' => 'nullable',
                    'mobile' => 'nullable|numeric|unique:vendors,mobile,' . $this->id,
                ];

                if (config('setting.supported_payments.upayment.account_type') == 'vendor_account') {
                    $rules['payment_data.ibans'] = 'required';
                    $rules['payment_data.fixed_app_commission'] = 'nullable|numeric';
                    $rules['payment_data.percentage_app_commission'] = 'nullable|numeric';
                }

                if (config('setting.other.select_shipping_provider') == 'vendor_delivery') {
                    $rules['delivery_time_types'] = 'required|array|min:1|in:direct,schedule';
                }

                if (isset($this->days_status) && !empty($this->days_status)) {
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
            'fixed_delivery.required' => __('vendor::dashboard.vendors.validation.fixed_delivery.required'),
            'fixed_delivery.numeric' => __('vendor::dashboard.vendors.validation.fixed_delivery.numeric'),
            'order_limit.required' => __('vendor::dashboard.vendors.validation.order_limit.required'),
            'order_limit.numeric' => __('vendor::dashboard.vendors.validation.order_limit.numeric'),
            'commission.required' => __('vendor::dashboard.vendors.validation.commission.required'),
            'commission.numeric' => __('vendor::dashboard.vendors.validation.commission.numeric'),
            'fixed_commission.required' => __('vendor::dashboard.vendors.validation.fixed_commission.required'),
            'fixed_commission.numeric' => __('vendor::dashboard.vendors.validation.fixed_commission.numeric'),
            'payment_id.required' => __('vendor::dashboard.vendors.validation.payments.required'),
            'seller_id.required' => __('vendor::dashboard.vendors.validation.sellers.required'),

            'section_id.required' => __('vendor::dashboard.vendors.validation.sections.required'),
            'section_id.exists' => __('vendor::dashboard.vendors.validation.sections.exists'),

            'vendor_category_id.required' => __('vendor::dashboard.vendors.validation.vendor_category_id.required'),
            'vendor_category_id.exists' => __('vendor::dashboard.vendors.validation.vendor_category_id.exists'),

            'image.required' => __('vendor::dashboard.vendors.validation.image.required'),
            'image.image' => __('vendor::dashboard.vendors.validation.image.image'),
            'image.mimes' => __('vendor::dashboard.vendors.validation.image.mimes'),
            'image.max' => __('vendor::dashboard.vendors.validation.image.max'),

            'mobile.required' => __('vendor::dashboard.vendors.validation.mobile.required'),
            'mobile.unique' => __('vendor::dashboard.vendors.validation.mobile.unique'),
            'mobile.numeric' => __('vendor::dashboard.vendors.validation.mobile.numeric'),
            'mobile.digits_between' => __('vendor::dashboard.vendors.validation.mobile.digits_between'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('vendor::dashboard.vendors.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique_translation"] = __('vendor::dashboard.vendors.validation.title.unique') . ' - ' . $value['native'] . '';
            $v["description." . $key . ".required"] = __('vendor::dashboard.vendors.validation.description.required') . ' - ' . $value['native'] . '';
        }

        if (isset($this->days_status) && !empty($this->days_status) /* && config('setting.other.select_shipping_provider') == 'vendor_delivery' */) {
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
