<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ToDoController extends Controller
{
    public function index()
    {
        $fechaSemana = Carbon::now()->addWeeks(1);
        $proximasCitas = Servicio::where('fechaSiguiente', '<=',  $fechaSemana)
        ->where(function ($query) {
            $query->where('finalizado', '<', 1);
        })->get();
        return view('index')->with(['proximasCitas' => $proximasCitas]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $servicio = Servicio::find($id);

        if($request->agendada === "on")
        	$servicio->agendada = 1;
        else
        	$servicio->agendada = 0;

        if($request->finalizado === "on")
        	$servicio->finalizado = 1;
        else
        	$servicio->finalizado = 0;

        if($servicio->save()){
            return redirect()->back()->with('success', 'Has agregado un nuevo servicio correctamente');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar un servicio, intentalo de nuevo.');
        }
    }
}
