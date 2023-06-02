<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CajaHerramienta;
use App\Models\Herramienta;
use App\Models\Empleado;
use App\Models\Historial;
use App\Models\HerramientaEnCaja;
use App\Models\EmpleadoCaja;

use App\Http\Requests\CajaRequest;

class CajaHerramientasController extends Controller
{

    public function index()
    {
        $caja_herramientas = CajaHerramienta::get();

        $empleados = Empleado::all();

        return view('cajas_herramientas')->with([
            'caja_herramientas' => $caja_herramientas,
            'empleados' => $empleados
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(CajaRequest $request)
    {
        $cajaHerramienta = new CajaHerramienta;
        $cajaHerramienta->notas = $request->notas;

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
        $historial->tabla = "Caja de Herramientas";

        $caja = CajaHerramienta::all();
        if ($caja->count())
            $caja_id = CajaHerramienta::orderBy('id', 'DESC')->first()->id;

        $historial->objeto = "Caja #";
        if(empty($caja_id))
            $historial->objeto .= "1";
        else
            $historial->objeto .= $caja_id + 1;
        $historial->save();

        if($cajaHerramienta->save())
        {
            if(!empty($request->empleado1))
                $cajaHerramienta->empleados()->attach($request->empleado1);

            if(!empty($request->empleado2))
                $cajaHerramienta->empleados()->attach($request->empleado2);

            return redirect()->back()->with('success', 'Has agregado una nueva Caja de Herramientas correctamente');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar agregar una Caja de Herramientas, intentalo de nuevo.');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cajaHerramienta = CajaHerramienta::find($id);

        $empleados = EmpleadoCaja::select('empleado_id')->where('caja_id', $id)->get();

        return response()->json([
            'id' => $cajaHerramienta->id,
            'empleados' => $empleados,
            'notas' => $cajaHerramienta->notas
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $cajaHerramienta = CajaHerramienta::find($id);
        $cajaHerramienta->notas = $request->notas;

        $caja_empleados = $cajaHerramienta->empleados;
        $flag1 = true;
        $flag2 = true;

        if(!empty($caja_empleados[0]->id)){
            if($request->empleado1 == $caja_empleados[0]->id)
                $flag1 = false;
        }

        if(!empty($caja_empleados[1]->id)){
            if($request->empleado2 == $caja_empleados[1]->id)
                $flag2 = false;
        }

        if($flag1)
        {
            if(!empty($request->empleado1))
            {
                $empleado1 = EmpleadoCaja::where('empleado_id', $request->empleado1)->get();
                if(count($empleado1) > 0)
                    return redirect()->back()->with('error', 'El empleado 1 ya está asignado a una caja');
            }
        }

        if($flag2)
        {
            if(!empty($request->empleado2))
            {
                $empleado2 = EmpleadoCaja::where('empleado_id', $request->empleado2)->get();
                if(count($empleado2) > 0)
                    return redirect()->back()->with('error', 'El empleado 2 ya está asignado a una caja');
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
        $historial->tabla = "Caja de Herramientas";
        $historial->objeto = "Caja #";
        $historial->objeto .= $id;
        $historial->save();

        if($cajaHerramienta->save())
        {
            if(empty($request->empleado1)){
                $empleado = new Empleado;
                $empleado->cajaHerramientas()->detach($id);
            }
            else
                $cajaHerramienta->empleados()->sync($request->empleado1);

            if(empty($request->empleado2))
            {
                $empleado = new Empleado;
                $empleado->cajaHerramientas()->detach($id);
            }
            else
                $cajaHerramienta->empleados()->syncWithoutDetaching($request->empleado2);

            return redirect()->back()->with('success', 'Has editado una nueva Caja de Herramientas correctamente');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar editar una Caja de Herramientas, intentalo de nuevo.');
        }
    }

    public function destroy($id)
    {
        $cajaHerramienta = CajaHerramienta::find($id); // Buscamos el registro

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
        $historial->tabla = "Caja de Herramientas";
        $historial->objeto = "Caja #";
        $historial->objeto .= $cajaHerramienta->id;
        $historial->save();

        //Para eliminar de la tabla de relacion
        $cajaHerramienta->herramientas()->detach();
        $cajaHerramienta->empleados()->detach();

        if($cajaHerramienta->delete()) {   // Lo eliminamos
            return redirect()->back()->with('success', 'Has eliminado una caja de herramientas correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar una caja de herramientas, intentalo de nuevo.');
        }
    }
}
