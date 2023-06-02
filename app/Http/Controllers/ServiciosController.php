<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio; //Modelo
use App\Http\Requests\ServiciosRequest;

class ServiciosController extends Controller
{

    public function index()
    {
        $servicios = Servicio::get();
        return view('servicios', compact('servicios'));
    }


    public function store(ServiciosRequest $request)
    {
        $servicio = new Servicio;
        $servicio->servicio = $request->servicio;
        $servicio->costo = $request->costo;
        $servicio->moneda = $request->moneda;
        $servicio->nombreCliente = $request->nombreCliente;
        $servicio->apellidoCliente = $request->apellidoCliente;
        $servicio->telCliente = $request->telCliente;
        $servicio->carro = $request->carro;
        $servicio->fecha = $request->fecha;
        $servicio->fechaSiguiente = $request->fechaSiguiente;
        $servicio->descripcion = $request->descripcion;
        if($servicio->save()){
            return redirect()->back()->with('success', 'Has agregado un nuevo servicio correctamente');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar un servicio, intentalo de nuevo.');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $servicio = Servicio::find($id);
        return response()->json([
            'id' => $servicio->id,
            'servicio' => $servicio->servicio,
            'costo' => $servicio->costo,
            'moneda' => $servicio->moneda,
            'nombreCliente' => $servicio->nombreCliente,
            'apellidoCliente' => $servicio->apellidoCliente,
            'telCliente' => $servicio->telCliente,
            'carro' => $servicio->carro,
            'fecha' => $servicio->fecha,
            'fechaSiguiente' => $servicio->fechaSiguiente,
            'descripcion' => $servicio->descripcion,
            'modificacion' => $servicio->updated_at
        ]);
    }


    public function update(ServiciosRequest $request)
    {
        $id = $request->id;

        $servicio = Servicio::find($id);

        $servicio->servicio = $request->servicio;
        $servicio->costo = $request->costo;
        $servicio->moneda = $request->moneda;
        $servicio->nombreCliente = $request->nombreCliente;
        $servicio->apellidoCliente = $request->apellidoCliente;
        $servicio->telCliente = $request->telCliente;
        $servicio->carro = $request->carro;
        $servicio->fecha = $request->fecha;
        $servicio->fechaSiguiente = $request->fechaSiguiente;
        $servicio->descripcion = $request->descripcion;
        if($servicio->save()){
            return redirect()->back()->with('success', 'Has editado un nuevo servicio correctamente');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar un servicio, intentalo de nuevo.');
        }
    }


    public function destroy($id)
    {
        $servicio = Servicio::find($id); // Buscamos el registro
        if($servicio->delete()) {   // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado un servicio correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar un servicio, intentalo de nuevo.');
        }
    }




}
