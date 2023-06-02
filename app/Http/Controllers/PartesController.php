<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Autoparte; // Modelo
use App\Historial;
use App\Http\Requests\AutoparteRequest;

class PartesController extends Controller
{

    public function index()
    { // TODO: Primero es necesario crear la tabla
        $autopartes = Autoparte::get();
        return view('partes', compact('autopartes'));
    }


    public function create()
    {
        //
    }


    public function store(AutoparteRequest $request)
    {
        $autoparte = new Autoparte;
        $autoparte->parte = $request->parte;
        $autoparte->modelo = $request->modelo;
        $autoparte->cantidad = $request->cantidad;
        $autoparte->marca = $request->marca;
        $autoparte->costo = $request->costo;
        $autoparte->moneda = $request->moneda;
        $autoparte->descripcion = $request->descripcion;
        $autoparte->modelosDisponibles = $request->modelos_disponibles;
        $autoparte->palancaCambios = $request->palancaCambios;
        $autoparte->cilindros = $request->cilindros;

        //Informacion del usuario
        $usuario = auth()->user();

        //Historial
        $historial = new Historial;
        $historial->user_id = $usuario->id;
        if($usuario->is_admin === 1)
            $historial->rol = "Administrador";
        else
            $historial->rol = "Gerente";
        $historial->accion = "Agregar";
        $historial->tabla = "Autopartes";
        $historial->objeto = $request->parte;
        $historial->objeto .= " ". $request->marca;
        $historial->save();

        if($autoparte->save()) { // Insertar el registro
            return redirect()->back()->with('success', 'Has agregado una nueva autoparte correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar una autoparte, intentalo de nuevo.');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $id = $request->id;

        $autoparte = Autoparte::find($id);

        return response()->json([
            'id' => $autoparte->id,
            'parte' => $autoparte->parte,
            'modelo' => $autoparte->modelo,
            'cantidad' => $autoparte->cantidad,
            'marca' => $autoparte->marca,
            'costo' => $autoparte->costo,
            'moneda' => $autoparte->moneda,
            'descripcion' => $autoparte->descripcion,
            'modelos_disponibles' => $autoparte->modelosDisponibles,
            'palancaCambios' => $autoparte->palancaCambios,
            'cilindros' => $autoparte->cilindros,
            'modificacion' => $autoparte->updated_at
        ]);
    }


    public function update(AutoparteRequest $request)
    {
        $id = $request->id;

        $autoparte = Autoparte::find($id);
        $autoparte->parte = $request->parte;
        $autoparte->modelo = $request->modelo;
        $autoparte->cantidad = $request->cantidad;
        $autoparte->marca = $request->marca;
        $autoparte->costo = $request->costo;
        $autoparte->moneda = $request->moneda;
        $autoparte->descripcion = $request->descripcion;
        $autoparte->modelosDisponibles = $request->modelos_disponibles;
        $autoparte->palancaCambios = $request->palancaCambios;
        $autoparte->cilindros = $request->cilindros;

        //Informacion del usuario
        $usuario = auth()->user();

        //Historial
        $historial = new Historial;
        $historial->user_id = $usuario->id;
        if($usuario->is_admin === 1)
            $historial->rol = "Administrador";
        else
            $historial->rol = "Gerente";
        $historial->accion = "Modificar";
        $historial->tabla = "Autopartes";
        $historial->objeto = $request->parte;
        $historial->objeto .= " ". $request->marca;
        $historial->save();

        if($autoparte->save()) { // Insertar el registro
            return redirect()->back()->with('success', 'Has editado una nueva autoparte correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar una autoparte, intentalo de nuevo.');
        }
    }


    public function destroy($id)
    {
        $autoparte = Autoparte::find($id); // Buscamos el registro

        //Informacion del usuario
        $usuario = auth()->user();

        //Historial
        $historial = new Historial;
        $historial->user_id = $usuario->id;
        if($usuario->is_admin === 1)
            $historial->rol = "Administrador";
        else
            $historial->rol = "Gerente";

        $historial->accion = "Eliminar";
        $historial->tabla = "Autopartes";
        $historial->objeto = $autoparte->parte;
        $historial->objeto .= " ". $autoparte->marca;
        $historial->save();


        //Para eliminar de la tabla de relacion
        $autoparte->ventas()->detach();

        if($autoparte->delete()) { // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado una autoparte correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar una autoparte, intentalo de nuevo.');
        }
    }
}
