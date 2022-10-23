<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBatchRequest extends FormRequest
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
            'comparment' => 'required',
            'batchID' => [
                'required',
                Rule::unique('batches','batchID')->ignore(request()->get('id'))
            ],
            'comparmentNo' => 'required',
            'cultivar' => 'required',
            'plantingDate' => 'sometimes',
            'triggerDate' => 'sometimes',
            'harvestDate' => 'sometimes',
            'transplantDate' => 'sometimes',
            'cloneDate' => 'sometimes',
            'cullDate' => 'sometimes',
        ];
    }
}
