<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiciosRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'servicio' => 'required|string|max:255',
            'costo' => 'required|numeric|max:999999',
            'moneda' => 'required|string',
            'nombreCliente' => 'required|string|max:255',
            'apellidoCliente' => 'required|string|max:255',
            'telCliente' => 'required|string',
            'carro' => 'required|string|max:255',
            'fecha' => 'required|date',
            'fechaSiguiente' => 'required|date',
            'descripcion' => 'string|nullable|max:20000'
        ];
    }
}
