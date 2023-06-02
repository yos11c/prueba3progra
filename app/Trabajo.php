<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = 'trabajos'; 
    
    public function empleados()
    {
    	return $this->belongsToMany(Empleado::class, 'empleado_trabajo', 'trabajo_id', 'empleado_id');
    }
}
