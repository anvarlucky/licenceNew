<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MountaineeringRequest extends FormRequest
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
            'licence_number' => 'required',
            //'licence_number' => 'unique:projects,licence_number_new',
            'licence_given_date' => 'required',
            'organization_inn' => 'required',
            //'organization_name' => 'required|unique:projects,organization_name',
            //'organization_phone' => 'required|unique:projects,organization_phone',
            //'license_direction' => 'required'
        ];
    }
}
