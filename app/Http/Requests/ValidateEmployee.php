<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class ValidateEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $company_ids = Company::get()->pluck('company_id')->all();
        if (count($company_ids) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company_ids = Company::get()->pluck('company_id')->all();
        return [
            'first_name'    => 'required|string|max:191',
            'last_name'     => 'required|string|max:191',
            'company_id'    => 'required|in:'.implode(',', $company_ids),
            'email_address' => 'required|email|max:191',
            'position'      => 'required|string|max:191',
            'city'          => 'required|string|max:191',
            'country'       => 'required|string|max:191',
            'status'        => 'required|in:0,1',
        ];
    }
}
