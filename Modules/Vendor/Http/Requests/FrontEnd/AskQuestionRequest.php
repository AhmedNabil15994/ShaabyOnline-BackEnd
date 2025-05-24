<?php

namespace Modules\Vendor\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class AskQuestionRequest extends FormRequest
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
                    'question' => 'required|max:3000',
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
            'name.required' => __('vendor::frontend.ask_question_form.validation.name.required'),
            'name.string' => __('vendor::frontend.ask_question_form.validation.name.string'),
            'name.max' => __('vendor::frontend.ask_question_form.validation.name.max'),
            'email.required' => __('vendor::frontend.ask_question_form.validation.email.required'),
            'email.email' => __('vendor::frontend.ask_question_form.validation.email.email'),
            'question.required' => __('vendor::frontend.ask_question_form.validation.question.required'),
            'question.max' => __('vendor::frontend.ask_question_form.validation.question.max'),
        ];

        return $v;

    }
}
