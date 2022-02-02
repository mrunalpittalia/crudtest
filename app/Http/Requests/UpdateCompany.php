<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompany extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name'        => 'required||max:191',
            'company_type'        => 'required|in:0,1,2,3',
            'website'             => 'sometimes|nullable|url',
            'company_description' => 'sometimes|nullable|string',
        ];
    }
}
