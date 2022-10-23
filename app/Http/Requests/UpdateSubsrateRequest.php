<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubsrateRequest extends FormRequest
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
            'subsrateID' => 'required',
            'eC' => 'required|gte:0|lt:15',
            'pH' => 'required|gte:0|lt:14',
        ];
    }

    public function messages()
    {
        return [
            'subsrateID' => 'The ec field is required.',
            'eC.required' => 'The ec field is required.',
            'eC.gte' => 'The ec must be greater than or equal 0.',
            'eC.lt' => 'The ec must be less than 15.',
            'pH.required' => 'The ph field is required.',
            'pH.gte' => 'The ph must be greater than or equal 0.',
            'pH.lt' => 'The ph must be less than 15.',
        ];
    }
}
