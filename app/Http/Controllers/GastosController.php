<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use App\Http\Requests\GastosRequest;

class GastosController extends Controller
{
    public function index()
    { 
        $gastos = Gasto::get();
        return view('gastos', compact('gastos'));
    }

	public function store(GastosRequest $request)
    {
        $gasto = new Gasto;
        $gasto->precio = $request->precio;
        $gasto->moneda = $request->moneda;
        $gasto->fecha = $request->fecha;
        $gasto->descripcion = $request->descripcion;

        if($gasto->save()) { // Insertar el registro
            return redirect()->back()->with('success', 'Has agregado un nuevo gasto correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar un gasto, intentalo de nuevo.');
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;

        $gasto = Gasto::find($id);

        return response()->json([
            'id' => $gasto->id,
            'precio' => $gasto->precio,
            'moneda' => $gasto->moneda,
            'fecha' => $gasto->fecha,
            'descripcion' => $gasto->descripcion
        ]);
    }

    public function update(GastosRequest $request)
    {
        $id = $request->id;

        $gasto = Gasto::find($id);
        $gasto->precio = $request->precio;
        $gasto->moneda = $request->moneda;
        $gasto->fecha = $request->fecha;
        $gasto->descripcion = $request->descripcion;

        if($gasto->save()) { // Insertar el registro
            return redirect()->back()->with('success', 'Has editado un gasto correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar un gasto, intentalo de nuevo.');
        }
    }

    public function destroy($id)
    {
        $gasto = Gasto::find($id); // Buscamos el registro

        if($gasto->delete()) { // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado un gasto correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar un gasto, intentalo de nuevo.');
        }
    }

}
