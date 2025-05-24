<?php

namespace Modules\Vendor\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
                    'name' => 'required|string|max:300',
                    'email' => 'required|email',
                    'image' => 'nullable|image|max:2048',
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
            'name.required' => __('vendor::frontend.prescription_form.validation.name.required'),
            'name.string' => __('vendor::frontend.prescription_form.validation.name.string'),
            'name.max' => __('vendor::frontend.prescription_form.validation.name.max'),
            'email.required' => __('vendor::frontend.prescription_form.validation.email.required'),
            'email.email' => __('vendor::frontend.prescription_form.validation.email.email'),
            'image.image' => __('vendor::frontend.prescription_form.validation.image.image'),
            'image.max' => __('vendor::frontend.prescription_form.validation.image.max'),
        ];

        return $v;

    }
}
