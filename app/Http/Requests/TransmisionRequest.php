<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransmisionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'cantidad' => 'required|integer',
            'marca' => 'required|string|max:255',
            'costo' => 'required|numeric',
            'descripcion' => 'string|nullable|max:20000',
            'modelos_disponibles' => 'required|string|max:20000',
            'palanca_cambios' => 'required|string'
        ];
    }
}
