<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Historial;

class HistorialController extends Controller
{
    public function index()
    {
        $historias = Historial::get(); 
        foreach ($historias as $historia) 
        {
            if(!empty($historia->user_id))
            {
                $historia->user = User::where('id', $historia->user_id)->first()->name;
                $historia->user .= ' '. User::where('id', $historia->user_id)->first()->primerApellido;
            }
            else
                $historia->user = "Ninguno";
        }
        return view('historial', compact('historias')); 
    }
}
