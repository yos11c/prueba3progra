<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CajaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'empleado1' => 'nullable|unique:empleado_caja,empleado_id',
            'empleado2' => 'nullable|unique:empleado_caja,empleado_id',
            'notas' => 'nullable|string'
        ];
    }
}
