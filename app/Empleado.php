<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados'; // Nombre de la tabla

    public function cajaHerramientas()
    {
    	return $this->belongsToMany(CajaHerramienta::class, 'empleado_caja', 'empleado_id', 'caja_id');
    }

    public function trabajos()
    {
    	return $this->belongsToMany(Trabajo::class, 'empleado_trabajo', 'empleado_id', 'trabajo_id');
    }

    public function faltas()
    {
    	return $this->belongsToMany(Falta::class, 'empleado_falta', 'empleado_id', 'falta_id');
    }
}
