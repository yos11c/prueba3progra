<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaltasRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'empleado' => 'required|numeric',
            'fecha' => 'required|date',
            'razon' => 'required|string|max:20000'
        ];
    }
}
