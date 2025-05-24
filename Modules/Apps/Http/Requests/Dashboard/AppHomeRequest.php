<?php

namespace Modules\Apps\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Apps\Entities\AppHome;
use Modules\Apps\Enums\AppHomeDisplayType;

class AppHomeRequest extends FormRequest
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

                $rules =  [
                    'type' => 'required|in:' . implode(',', AppHome::TYPES),
                    'display_type' => 'required|in:' .  implode(',', AppHomeDisplayType::getConstList()),
                    'grid_columns_count' => 'nullable|numeric|max:6|min:1',
                ];

                foreach (AppHome::TYPES as $type => $name) {
                    $rules[$type] = 'required_if:type,' . $type . '|array';
                    $rules[$type . '.*'] = 'required|exists:' . AppHome::getClassNameByType($type) . ',id';
                }

                return $rules;
                //handle updates
            case 'put':
            case 'PUT':
                return [];
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
}
