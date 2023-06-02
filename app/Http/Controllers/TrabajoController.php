<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado; // Modelo
use App\EmpleadoTrabajo;
use App\Trabajo;
use App\Http\Requests\TrabajoRequest;

class TrabajoController extends Controller
{

    public function index()
    {
        $trabajos = Trabajo::all();
        $empleados = Empleado::all();
        return view('trabajos')->with([
            'trabajos' => $trabajos,
            'empleados' => $empleados
        ]);
    }


    public function store(TrabajoRequest $request)
    {
        $trabajo = new Trabajo;

        $trabajo->descripcion = $request->descripcion;
        $trabajo->fechaLlegada = $request->fechaLlegada;
        $trabajo->fechaInicio = $request->fechaInicio;
        $trabajo->fechaFinal = $request->fechaFinal;

        if($trabajo->save()) { // Insertar el registro
            $trabajo->empleados()->attach($request->empleado);

            return redirect()->back()->with('success', 'Has agregado un nuevo trabajo correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar un trabajo, intentalo de nuevo.');
        }
    }

    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $id = $request->id;

        $trabajo = Trabajo::find($id);

        $empleados = EmpleadoTrabajo::select('empleado_id')->where('trabajo_id', $id)->get();

        return response()->json([
            'id' => $trabajo->id,
            'empleado' => $empleados,
            'descripcion' => $trabajo->descripcion,
            'fechaLlegada' => $trabajo->fechaLlegada,
            'fechaInicio' => $trabajo->fechaInicio,
            'fechaFinal' => $trabajo->fechaFinal
        ]);
    }


    public function update(TrabajoRequest $request)
    {
        $id = $request->id;

        $trabajo = Trabajo::find($id);
        $trabajo->descripcion = $request->descripcion;
        $trabajo->fechaLlegada = $request->fechaLlegada;
        $trabajo->fechaInicio = $request->fechaInicio;
        $trabajo->fechaFinal = $request->fechaFinal;

        if($trabajo->save()) { // Insertar el registro
            $trabajo->empleados()->sync($request->empleado);
            return redirect()->back()->with('info', 'Has editado un trabajo correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar un trabajo, intentalo de nuevo.');
        }
    }


    public function destroy($id)
    {
        $trabajo = Trabajo::find($id); // Buscamos el registro
        $trabajo->empleados()->detach();

        if($trabajo->delete()) { // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado un trabajo correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar un trabajo, intentalo de nuevo.');
        }
    }
}
