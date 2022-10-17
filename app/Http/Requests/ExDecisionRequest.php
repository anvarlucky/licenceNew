<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExDecisionRequest extends FormRequest
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
            'decision_start_date' => 'required',
            'decision_number' => 'required'
        ];
    }
}
