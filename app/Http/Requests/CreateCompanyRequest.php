<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                   => 'required|min:2',
            'detail.ogrn'            => 'numeric|digits_between:13,15',
            'detail.inn'             => 'numeric|digits:12',
            'detail.kpp'             => 'numeric|digits:9',
            'authorized_capital'     => 'numeric'
        ];
    }
}
