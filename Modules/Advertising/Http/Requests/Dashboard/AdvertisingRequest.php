<?php

namespace Modules\Advertising\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisingRequest extends FormRequest
{
    protected $types = 'external,product,category,vendor';

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
                    'link_type' => 'nullable|in:' . $this->types,
                    'link' => 'required_if:link_type,==,external',
                    'image' => 'required|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                    'group_id' => 'required|exists:advertising_groups,id',
                    'start_at' => 'required',
                    'end_at' => 'required',
                ];

                if ($this->link_type == 'product')
                    $rules['product_id'] = 'required|exists:products,id';

                if ($this->link_type == 'category')
                    $rules['category_id'] = 'required|exists:categories,id';

                if ($this->link_type == 'vendor')
                    $rules['vendor_id'] = 'required|exists:vendors,id';

                return $rules;

                //handle updates
            case 'put':
            case 'PUT':
                $rules = [
                    'link_type' => 'nullable|in:' . $this->types,
                    'link' => 'required_if:link_type,==,external',
                    'group_id' => 'required|exists:advertising_groups,id',
                    'start_at' => 'required',
                    'end_at' => 'required',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

                if ($this->link_type == 'product')
                    $rules['product_id'] = 'required|exists:products,id';

                if ($this->link_type == 'category')
                    $rules['category_id'] = 'required|exists:categories,id';

                if ($this->link_type == 'vendor')
                    $rules['vendor_id'] = 'required|exists:vendors,id';

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
            'link_type.required' => __('advertising::dashboard.advertising.validation.link_type.required'),
            'link_type.in' => __('advertising::dashboard.advertising.validation.link_type.in'),
            'link.required_if' => __('advertising::dashboard.advertising.validation.link.required_if'),
            'product_id.required' => __('advertising::dashboard.advertising.validation.product_id.required'),
            'product_id.exists' => __('advertising::dashboard.advertising.validation.product_id.exists'),
            'category_id.required' => __('advertising::dashboard.advertising.validation.category_id.required'),
            'category_id.exists' => __('advertising::dashboard.advertising.validation.category_id.exists'),
            'group_id.required' => __('advertising::dashboard.advertising.validation.group_id.required'),
            'group_id.exists' => __('advertising::dashboard.advertising.validation.group_id.exists'),
            'start_at.required' => __('advertising::dashboard.advertising.validation.start_at.required'),
            'end_at.required' => __('advertising::dashboard.advertising.validation.end_at.required'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        return $v;
    }
}
