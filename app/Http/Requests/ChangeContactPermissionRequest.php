<?php

namespace App\Http\Requests;

use App\Models\ContactPermission;
use Illuminate\Foundation\Http\FormRequest;

class ChangeContactPermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $modes = implode(',', ContactPermission::getModes());

        return [
            'mode'      => "required|in:$modes",
            'user_id'   => 'required'
        ];
    }
}
