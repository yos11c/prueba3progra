<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use App\EmpleadoFalta;
use App\Falta;
use App\Http\Requests\FaltasRequest;

class FaltasController extends Controller
{
    public function index()
    { 
        $faltas = Falta::get();
        $empleados = Empleado::get();
        return view('faltas')->with([
        	'faltas' => $faltas,
        	'empleados' => $empleados
        ]);
    }

	public function store(FaltasRequest $request)
    {
        $falta = new Falta;
        //$falta->empleado_id = $request->empleado;

        if ($request->justificacion === "on") 
        	$falta->justificacion = 1;
       else
        	$falta->justificacion = 0;

        $falta->razon = $request->razon;
        $falta->fecha = $request->fecha;

        if($falta->save()) { // Insertar el registro
            $falta->empleados()->attach($request->empleado);
            return redirect()->back()->with('success', 'Has agregado una nueva falta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar una falta, intentalo de nuevo.');
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $falta = Falta::find($id);
        $empleados = EmpleadoFalta::select('empleado_id')->where('falta_id', $id)->get();

        return response()->json([
            'id' => $falta->id,
            'empleado' => $empleados,
            'justificacion' => $falta->justificacion,
            'razon' => $falta->razon,
            'fecha' => $falta->fecha
        ]);
    }

    public function update(FaltasRequest $request)
    {
        $id = $request->id;

        $falta = Falta::find($id);

        if ($request->justificacion === "on") 
        	$falta->justificacion = 1;
        else
        	$falta->justificacion = 0;

        $falta->razon = $request->razon;
        $falta->fecha = $request->fecha;
        
        if($falta->save()) { // Insertar el registro
            $falta->empleados()->sync($request->empleado);
            return redirect()->back()->with('success', 'Has editado una falta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar una falta, intentalo de nuevo.');
        }
    }

    public function destroy($id)
    {
        $falta = Falta::find($id); // Buscamos el registro

        $falta->empleados()->detach();

        if($falta->delete()) { // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado una falta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar una falta, intentalo de nuevo.');
        }
    }

}
