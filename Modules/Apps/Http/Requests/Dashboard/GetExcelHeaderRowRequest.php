<?php

namespace Modules\Apps\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Apps\Entities\AppHome;

class GetExcelHeaderRowRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  [
            'excel_file' => 'required',
        ];
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
