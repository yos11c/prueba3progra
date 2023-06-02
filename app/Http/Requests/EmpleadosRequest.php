<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadosRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:25',
            'primerApellido' => 'required|string|max:255'
        ];
    }
}
