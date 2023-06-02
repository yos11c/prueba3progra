<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ventas;
use App\Motor;
use App\Transmision;
use App\Autoparte;

use App\VentaAutoparte;
use App\VentaTransmision;
use App\VentaMotor;

use App\Http\Requests\VentasRequest;

class VentasController extends Controller
{

    public function index()
    {
        $ventas = Ventas::all();
        $motores = Motor::where('cantidad', '>', 0)->get();
        $motoresall = Motor::all();
        $transmisiones = Transmision::where('cantidad', '>', 0)->get();
        $transmisionesall = Transmision::all();
        $autopartes = Autoparte::where('cantidad', '>', 0)->get();
        $autopartesall = Autoparte::all();
        return view('ventas')->with([
            'ventas' => $ventas,
            'motores'           => $motores,
            'motoresall'        => $motoresall,
            'transmisiones'     => $transmisiones,
            'transmisionesall'  => $transmisionesall,
            'autopartes'        => $autopartes,
            'autopartesall'     => $autopartesall
        ]);
    }


    public function store(VentasRequest $request)
    {
        $ventas = new Ventas;
        $ventas->nombre             = $request->nombre;
        $ventas->apellido           = $request->apellido;
        $ventas->telefono           = $request->telefono;
        $ventas->descripcion        = $request->descripcion;
        $ventas->costo              = $request->costo;
        $ventas->moneda             = $request->moneda;

        if($ventas->save()) // Insertar el registro
        {
            if(!empty($request->motor) && is_numeric($request->motor))
            {
                $motor = Motor::where('id', $request->motor)->get();
                if($request->cantidadMotor <= $motor[0]->cantidad)
                {
                    // Decrementar la cantidad
                    Motor::where('id', $request->motor)->decrement('cantidad', $request->cantidadMotor);
                    $ventas->motores()->attach($request->motor, ['cantidad' => $request->cantidadMotor]);
                }
                else
                {
                    return redirect()->back()->with('error', 'La cantidad del motor es menor a la que se intenta vender');
                }
            }

            if(!empty($request->transmision) && is_numeric($request->transmision))
            {
                $transmision = Transmision::where('id', $request->transmision)->get();
                if($request->cantidadTransmision <= $transmision[0]->cantidad)
                {
                    // Decrementar la cantidad
                    Transmision::where('id', $request->transmision)->decrement('cantidad',
                                                                            $request->cantidadTransmision);
                    $ventas->transmisiones()->attach($request->transmision,
                                                    ['cantidad' => $request->cantidadTransmision]);
                }
                else
                {
                    return redirect()->back()->with('error', 'La cantidad de la transmision es menor a la que se intenta vender');
                }
            }

            if(!empty($request->autoparte) && is_numeric($request->autoparte))
            {
                $autoparte = Autoparte::where('id', $request->autoparte)->get();
                if($request->cantidadAutoparte <= $autoparte[0]->cantidad)
                {
                    // Decrementar la cantidad
                    Autoparte::where('id', $request->autoparte)->decrement('cantidad', $request->cantidadAutoparte);
                    $ventas->autopartes()->attach($request->autoparte, ['cantidad' => $request->cantidadAutoparte]);
                }
                else
                {
                    return redirect()->back()->with('error', 'La cantidad de la autoparte es menor a la que se intenta vender');
                }
            }

            return redirect()->back()->with('success', 'Has agregado una nueva venta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar una venta, intentalo de nuevo.');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $id = $request->id;

        $venta = Ventas::find($id);

        $autoparte = VentaAutoparte::select('autoparte_id')->where('venta_id',$id)->get();
        $cantidadAutoparte = VentaAutoparte::select('cantidad')->where('venta_id',$id)->get();

        $motor = VentaMotor::select('motor_id')->where('venta_id',$id)->get();
        $cantidadMotor = VentaMotor::select('cantidad')->where('venta_id',$id)->get();

        $transmision = VentaTransmision::select('transmision_id')->where('venta_id',$id)->get();
        $cantidadTransmision = VentaTransmision::select('cantidad')->where('venta_id',$id)->get();

        return response()->json([
            'id' => $venta->id,
            'nombre' => $venta->nombre,
            'apellido' => $venta->apellido,
            'telefono' => $venta->telefono,
            'descripcion' => $venta->descripcion,
            'costo' => $venta->costo,
            'moneda' => $venta->moneda,
            'id_motor' => $motor,
            'cantidadMotor' => $cantidadMotor,
            'id_transmision' => $transmision,
            'cantidadTransmision' => $cantidadTransmision,
            'id_autoparte' => $autoparte,
            'cantidadAutoparte' => $cantidadAutoparte
        ]);
    }


    public function update(VentasRequest $request)
    {
        $id = $request->id;

        $ventas = Ventas::find($id);
        $ventas->nombre             = $request->nombre;
        $ventas->apellido           = $request->apellido;
        $ventas->telefono           = $request->telefono;
        $ventas->descripcion        = $request->descripcion;
        $ventas->costo              = $request->costo;
        $ventas->moneda             = $request->moneda;

        $venta_motores = $ventas->motores;
        $venta_transmisiones = $ventas->transmisiones;
        $venta_autopartes = $ventas->autopartes;

            if(!empty($request->motor) && is_numeric($request->motor))
            {
                if($venta_motores[0]->pivot->motor_id == $request->motor)
                {
                    $motor = Motor::where('id', $request->motor)->get();
                    if($request->cantidadMotor <= $motor[0]->cantidad)
                    {
                        $total = $request->cantidadMotor;
                        if ($venta_motores[0]->pivot->cantidad > $request->cantidadMotor)
                        {
                            $total = $venta_motores[0]->pivot->cantidad - $request->cantidadMotor;
                            // Incrementar la cantidad
                            Motor::where('id', $request->motor)->increment('cantidad', $total);
                        }
                        if ($venta_motores[0]->pivot->cantidad < $request->cantidadMotor)
                        {
                            $total = $request->cantidadMotor - $venta_motores[0]->pivot->cantidad;
                            // Decrementar la cantidad
                            Motor::where('id', $request->motor)->decrement('cantidad', $total);
                        }
                        $ventas->motores()->detach();
                        $ventas->motores()->attach($request->motor, ['cantidad' => $request->cantidadMotor]);
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'La cantidad del motor es menor a la que se intenta vender');
                    }
                }
                else
                {
                    $motor = Motor::where('id', $request->motor)->get();
                    if($request->cantidadMotor <= $motor[0]->cantidad)
                    {
                        Motor::where('id', $request->motor)->decrement('cantidad', $request->cantidadMotor);
                        $ventas->motores()->detach();
                        $ventas->motores()->attach($request->motor, ['cantidad' => $request->cantidadMotor]);
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'La cantidad del motor es menor a la que se intenta vender');
                    }
                }
            }

            if(!empty($request->transmision) && is_numeric($request->transmision))
            {
                if($venta_transmisiones[0]->pivot->transmision_id == $request->transmision)
                {
                    $transmision = Transmision::where('id', $request->transmision)->get();
                    if($request->cantidadTransmision <= $transmision[0]->cantidad)
                    {
                        $total = $request->cantidadTransmision;
                        if ($venta_transmisiones[0]->pivot->cantidad > $request->cantidadTransmision)
                        {
                            $total = $venta_transmisiones[0]->pivot->cantidad - $request->cantidadTransmision;
                            // Incrementar la cantidad
                            Transmision::where('id', $request->transmision)->increment('cantidad', $total);
                        }
                        if ($venta_transmisiones[0]->pivot->cantidad < $request->cantidadTransmision)
                        {
                            $total = $request->cantidadTransmision - $venta_transmisiones[0]->pivot->cantidad;
                            // Decrementar la cantidad
                            Transmision::where('id', $request->transmision)->decrement('cantidad', $total);
                        }
                        $ventas->transmisiones()->detach();
                        $ventas->transmisiones()->attach($request->transmision, ['cantidad' =>
                                                                                $request->cantidadTransmision]);
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'La cantidad de la transmision es menor a la que se intenta vender');
                    }
                }
                else
                {
                    $transmision = Transmision::where('id', $request->transmision)->get();
                    if($request->cantidadTransmision <= $transmision[0]->cantidad)
                    {
                        Transmision::where('id', $request->transmision)->decrement('cantidad',
                                                                                    $request->cantidadTransmision);
                        $ventas->transmisiones()->detach();
                        $ventas->transmisiones()->attach($request->transmision, ['cantidad' =>
                                                                                $request->cantidadTransmision]);
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'La cantidad de la transmision es menor a la que se intenta vender');
                    }
                }
            }

            if(!empty($request->autoparte) && is_numeric($request->autoparte))
            {
                if($venta_autopartes[0]->pivot->autoparte_id == $request->autoparte)
                {
                    $autoparte = Autoparte::where('id', $request->autoparte)->get();
                    if($request->cantidadAutoparte <= $autoparte[0]->cantidad)
                    {
                        $total = $request->cantidadAutoparte;
                        if ($venta_autopartes[0]->pivot->cantidad > $request->cantidadAutoparte)
                        {
                            $total = $venta_autopartes[0]->pivot->cantidad - $request->cantidadAutoparte;
                            // Incrementar la cantidad
                            Autoparte::where('id', $request->autoparte)->increment('cantidad', $total);
                        }
                        if ($venta_autopartes[0]->pivot->cantidad < $request->cantidadAutoparte)
                        {
                            $total = $request->cantidadAutoparte - $venta_autopartes[0]->pivot->cantidad;
                            // Decrementar la cantidad
                            Autoparte::where('id', $request->autoparte)->decrement('cantidad', $total);
                        }
                        $ventas->autopartes()->detach();
                        $ventas->autopartes()->attach($request->autoparte, ['cantidad' =>
                                                                            $request->cantidadAutoparte]);
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'La cantidad de la autoparte es menor a la que se intenta vender');
                    }
                }
                else
                {
                    $autoparte = Autoparte::where('id', $request->autoparte)->get();
                    if($request->cantidadAutoparte <= $autoparte[0]->cantidad)
                    {
                        Autoparte::where('id', $request->autoparte)->decrement('cantidad',
                                                                                $request->cantidadAutoparte);
                        $ventas->autopartes()->detach();
                        $ventas->autopartes()->attach($request->autoparte, ['cantidad' =>
                                                                            $request->cantidadAutoparte]);
                    }
                    else
                    {
                        return redirect()->back()->with('error', 'La cantidad de la autoparte es menor a la que se intenta vender');
                    }
                }
            }

        if($ventas->save()) { // Insertar el registro
            return redirect()->back()->with('info', 'Has editado una venta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar una venta, intentalo de nuevo.');
        }
    }


    public function destroy($id)
    {
        $ventas = Ventas::find($id); // Buscamos el registro

        //Para eliminar de la tabla de relacion
        $ventas->motores()->detach();
        $ventas->transmisiones()->detach();
        $ventas->autopartes()->detach();

        if($ventas->delete()) { // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado una venta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar una venta, intentalo de nuevo.');
        }
    }
}
