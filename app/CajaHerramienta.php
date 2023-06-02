<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaHerramienta extends Model
{
    protected $table = 'caja_herramientas'; // Nombre de la tabla

    public function herramientas()
    {
    	return $this->belongsToMany(Herramienta::class, 'herramienta_caja', 'caja_id', 'herramienta_id')
    		->withPivot('herramienta_id', 'cantidad');
    }

    public function empleados()
    {
    	return $this->belongsToMany(Empleado::class, 'empleado_caja', 'caja_id', 'empleado_id');
    }
}
