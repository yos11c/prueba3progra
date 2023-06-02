<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GastosRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'precio' => 'required|numeric',
            'fecha' => 'required|date',
            'moneda' => 'required|string',
            'descripcion' => 'required|string|max:20000'
        ];
    }
}
