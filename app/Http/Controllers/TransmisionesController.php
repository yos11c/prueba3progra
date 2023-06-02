<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transmision; // Modelo para llamar a la tabla de transmisiones
use App\Historial;
use App\Http\Requests\TransmisionRequest;


class TransmisionesController extends Controller
{

    public function index()
    {
        $transmisiones = Transmision::get();
        return view('transmisiones', compact('transmisiones'));
    }


    public function store(TransmisionRequest $request)
    {
        $transmision = new Transmision;
        $transmision->nombre              = $request->nombre;
        $transmision->modelo              = $request->modelo;
        $transmision->cantidad            = $request->cantidad;
        $transmision->marca               = $request->marca;
        $transmision->costo               = $request->costo;
        $transmision->moneda              = $request->moneda;
        $transmision->descripcion         = $request->descripcion;
        $transmision->modelosDisponibles  = $request->modelos_disponibles;
        $transmision->palancaCambios      = $request->palanca_cambios ;

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
        $historial->tabla = "Transmisiones";
        $historial->objeto = $request->nombre;
        $historial->objeto .= " ". $request->marca;
        $historial->save();

        if($transmision->save()) { // Insertar el registro
            return redirect()->back()->with('success', 'Has agregado una nueva transmision correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar una transmision, intentalo de nuevo.');
        }
    }



    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $id = $request->id;

        $transmision = Transmision::find($id);

        return response()->json([
            'id' => $transmision->id,
            'nombre' => $transmision->nombre,
            'modelo' => $transmision->modelo,
            'cantidad' => $transmision->cantidad,
            'marca' => $transmision->marca,
            'costo' => $transmision->costo,
            'moneda' => $transmision->moneda,
            'descripcion' => $transmision->descripcion,
            'modelos_disponibles' => $transmision->modelosDisponibles,
            'palanca_cambios' => $transmision->palancaCambios ,
            'modificacion' => $transmision->updated_at
        ]);
    }


    public function update(TransmisionRequest $request)
    {
        $id = $request->id;

        $transmision = Transmision::find($id);
        $transmision->nombre              = $request->nombre;
        $transmision->modelo              = $request->modelo;
        $transmision->cantidad            = $request->cantidad;
        $transmision->marca               = $request->marca;
        $transmision->costo               = $request->costo;
        $transmision->moneda              = $request->moneda;
        $transmision->descripcion         = $request->descripcion;
        $transmision->modelosDisponibles  = $request->modelos_disponibles;
        $transmision->palancaCambios      = $request->palanca_cambios;

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
        $historial->tabla = "Transmisiones";
        $historial->objeto = $request->nombre;
        $historial->objeto .= " ". $request->marca;
        $historial->save();

        if($transmision->save()) { // Insertar el registro
            return redirect()->back()->with('info', 'Has editado una transmision correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar una transmision, intentalo de nuevo.');
        }
    }

    public function destroy($id)
    {
        $transmision = Transmision::find($id); // Buscamos el registro

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
        $historial->tabla = "Transmisiones";
        $historial->objeto = $transmision->nombre;
        $historial->objeto .= " ". $transmision->marca;
        $historial->save();

        //Para eliminar de la tabla de relacion
        $transmision->ventas()->detach();

        if($transmision->delete()) { // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado una transmision correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar una transmision, intentalo de nuevo.');
        }
    }
}
