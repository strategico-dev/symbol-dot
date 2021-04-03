<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'    => 'required|min:2',
            'surname'       => 'min:2',
            'middle_name'   => 'min:2',
            'email'         => 'email'
        ];
    }
}
