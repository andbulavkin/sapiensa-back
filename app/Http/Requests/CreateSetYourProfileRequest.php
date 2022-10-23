<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSetYourProfileRequest extends FormRequest
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
            'growUnit' => 'required',
            'electricalConductivity' => 'required',
            'flower' => 'required|gt:-1',
            'clone' => 'required|gt:-1',
            'mother' => 'required|gt:-1',
            'vegitative' => 'required|gt:-1',
        ];
    }
}
