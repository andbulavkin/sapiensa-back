<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFeedSubRequest extends FormRequest
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
            'feedID' => 'sometimes',
            'fromDay' => 'required',
            'toDay' => 'required',
            'ecMinMax' => 'required|gt:0|lt:15',
            'phMinMax' => 'required|gt:0|lt:14',
        ];
    }
}
