<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GerenteRequestEdit extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'primerApellido' => 'required|string|max:255',
            'email' => 'required|unique:users,email',
        ];
    }
}
