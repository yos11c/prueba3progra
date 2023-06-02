<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CajaHerramienta;
use App\Herramienta; // Modelo
use App\Historial;
use App\HerramientaEnCaja;
use App\Http\Requests\HerramientasRequest;

class HerramientasController extends Controller
{

    public function index()
    {
        $herramientas = Herramienta::all();
        foreach ($herramientas as $herramienta)
        {
            $herramienta->caja = HerramientaEnCaja::select('caja_id')->where('herramienta_id', $herramienta->id)
                ->get();

            //Esto es para saber las cajas donde se encuentra la herramienta
            if(count($herramienta->caja) == 0)
                $herramienta->caja = "Ninguna";
            else
            {
                $json = $herramienta->caja;
                $herramienta->caja = "";
                $arr = [];
                for($i=0; $i<count($json); $i++)
                {
                    $arr[$i] = $json[$i]->caja_id;
                }
                $herramienta->caja = implode(", ", $arr);
            }
        }
        $cajas = CajaHerramienta::all();
    	return view('herramientas')->with([
            'herramientas' => $herramientas,
            'cajas'         => $cajas
        ]);
    }


    public function create()
    {
        //
    }

    public function store(HerramientasRequest $request)
    {
        $herramienta = new Herramienta;
        $herramienta->cantidad              = $request->cantidad;
        $herramienta->marca                 = $request->marca;
        $herramienta->nombre                = $request->nombre;
        $herramienta->descripcion           = $request->descripcion;

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
        $historial->tabla = "Herramientas";
        $historial->objeto = $request->nombre;
        $historial->objeto .= " ". $request->marca;
        $historial->save();

        //Para la tabla de la relacion
        $cantidadCaja = $request->input('cantidadCaja'); // array de textbox
        $cajas = $request->input('caja_herramientas');  // array de checkbox

        $j = 0;
        $total = 0;
        if(!empty($cantidadCaja))
        {
            for($i=0; $i<count($cantidadCaja); $i++)
                if(!empty($cantidadCaja[$i]))
                {  //Verificar que no estén vacíos
                    $cantidadReal[$j] = $cantidadCaja[$i]; // Se agrega al array los valores no vacíos
                    $total += $cantidadReal[$j];
                    $j++;
                }
        }

        if(intval($total) > intval($request->cantidad))
            return redirect()->back()->with('error', 'La cantidad de piezas que hay en las cajas es mayor a la cantidad que se tiene de la herramienta.');

        if(!empty($cantidadReal))
        {
            if(count($cantidadReal) < count($cajas))
                return redirect()->back()->with('error', 'No todas las cajas marcadas tienen cantidad de herramienta.');
            elseif (count($cantidadReal) > count($cajas))
            {
                return redirect()->back()->with('error','Hay menos cajas marcadas que cantidad de herramienta por caja.');
            }
        }

        if($herramienta->save()) { // Insertar el registro
            //Para la tabla de la relacion
            $herramienta_id = Herramienta::orderBy('id', 'DESC')->first()->id;
            if(!empty($cajas) && !empty($cantidadReal))
                for ($i=0; $i<count($cajas) ; $i++) {
                    $herramienta->cajaHerramientas()->attach($cajas[$i], ['cantidad' => $cantidadReal[$i]]);
                }

            return redirect()->back()->with('success', 'Has agregado una nueva herramienta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar una herramienta, intentalo de nuevo.');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $id = $request->id;

        $herramienta = Herramienta::find($id);
        $herramientaCaja = HerramientaEnCaja::select('caja_id')->where('herramienta_id', $id)->get();
        $cantidadCaja = HerramientaEnCaja::select('cantidad')->where('herramienta_id', $id)->get();

        return response()->json([
            'id' => $herramienta->id,
            'cantidad' => $herramienta->cantidad,
            'marca' => $herramienta->marca,
            'nombre' => $herramienta->nombre,
            'descripcion' => $herramienta->descripcion,
            'caja_herramientas' => $herramientaCaja,
            'cantidadCaja' => $cantidadCaja
        ]);
    }

    public function update(HerramientasRequest $request)
    {
        $id = $request->id;

        $herramienta = Herramienta::find($id);
        $herramienta->cantidad              = $request->cantidad;
        $herramienta->marca                 = $request->marca;
        $herramienta->nombre                = $request->nombre;
        $herramienta->descripcion           = $request->descripcion;

        //Para la tabla de la relacion
        $cantidadCaja = $request->input('cantidadCaja'); // array de textbox
        $cajas = $request->input('caja_herramientas');  // array de checkbox

        $j = 0;
        $total = 0;
        for($i=0; $i<count($cantidadCaja); $i++)
            if(!empty($cantidadCaja[$i])){  //Verificar que no estén vacíos
                $cantidadReal[$j] = $cantidadCaja[$i]; // Se agrega al array los valores no vacíos
                $total += $cantidadReal[$j];
                $j++;
            }

        if(intval($total) > intval($request->cantidad))
            return redirect()->back()->with('error', 'La cantidad de piezas que hay en las cajas es mayor a la cantidad que se tiene de la herramienta.');

        if(!empty($cantidadReal))
        {
            if(count($cantidadReal) < count($cajas))
                return redirect()->back()->with('error', 'No todas las cajas marcadas tienen cantidad de herramienta.');
            elseif (count($cantidadReal) > count($cajas))
            {
                return redirect()->back()->with('error','Hay menos cajas marcadas que cantidad de herramienta por caja.');
            }
        }

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
        $historial->tabla = "Herramientas";
        $historial->objeto = $request->nombre;
        $historial->objeto .= " ". $request->marca;
        $historial->save();

        if($herramienta->save()) { // Insertar el registro

            //Para la tabla de la relacion
            if(!empty($cajas))
            {
                $herramienta->cajaHerramientas()->detach();
                for ($i=0; $i<count($cajas) ; $i++) {
                    $herramienta->cajaHerramientas()->attach($cajas[$i], ['cantidad' => $cantidadReal[$i]]);
                }
            }

            return redirect()->back()->with('info', 'Has editado una herramienta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar una herramienta, intentalo de nuevo.');
        }
    }


    public function destroy($id)
    {
        $herramienta = Herramienta::find($id); // Buscamos el registro

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
        $historial->tabla = "Herramientas";
        $historial->objeto = $herramienta->nombre;
        $historial->objeto .= " ". $herramienta->marca;
        $historial->save();

        //Para eliminar de la tabla de relacion
        $herramienta->cajaHerramientas()->detach();

        if($herramienta->delete()) { // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado una herramienta correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar una herramienta, intentalo de nuevo.');
        }
    }
}
