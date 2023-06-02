<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrabajoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'empleado' => 'nullable|numeric',
            'descripcion' => 'nullable|string|max:20000',
            'fechaLlegada' => 'nullable|date',
            'fechaInicio' => 'nullable|date',
            'fechaFinal' => 'nullable|date'
        ];
    }
}
