<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBatchRequest extends FormRequest
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
        $rules = [
            'comparment' => 'required|in:Flower,Vegetative,Clone,Mother',
            'batchID' => 'required|max:15|unique:batches', //
            'cultivar' => 'required',
            'comparmentNo' => 'required',
            // 'plantingDate' => 'required',
            // 'cloneDate' => 'required',
            'triggerDate' => 'sometimes',
            'harvestDate' => 'sometimes',
            'transplantDate' => 'sometimes',
            'cullDate' => 'sometimes',
        ];
        if (request()->get('comparment') == 'Flower' || request()->get('comparment') == 'Vegetative' || request()->get('comparment') == 'Mother') {
            $rules['plantingDate'] = 'required';
            $rules['cloneDate'] = 'sometimes';
        } else {
            $rules['plantingDate'] = 'sometimes';
            $rules['cloneDate'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'batchID.required' => 'The batch id field is required.',
            'batchID.unique' => 'The batch id has already been taken.',
        ];
    }
}
