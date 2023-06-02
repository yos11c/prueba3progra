<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentasRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'telefono' => 'required|string',
            'descripcion' => 'nullable|string|max:20000',
            'costo' => 'required|numeric',
            'moneda' => 'required|string',
            'motor' => 'nullable|numeric',
            'transmision' => 'nullable|numeric',
            'autoparte' => 'nullable|numeric',
            'cantidadMotor' => 'nullable|integer',
            'cantidadTransmision' => 'nullable|integer',
            'cantidadAutoparte' => 'nullable|integer'
        ];
    }
}
