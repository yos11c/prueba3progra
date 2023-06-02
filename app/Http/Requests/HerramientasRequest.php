<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HerramientasRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'cantidad' => 'required|numeric|max:99999',
            'marca' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'string|nullable|max:20000'
        ];
    }
}
