<?php

namespace Modules\Authentication\Http\Requests\WebService;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VerifiedCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "calling_code" => "required",
            "code" => ["required"],
        ];

        if (auth('api')->guest()) {
            $rules['mobile'] = ['required', 'numeric', 'digits_between:3,20'];
        } else {
            $rules['mobile'] = ['required', 'numeric', 'digits_between:3,20', Rule::exists("users", "mobile")->where(function ($query) {
                $query->where("calling_code", $this->calling_code);
            })];
        }
        return $rules;
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
        return [];
    }
}
