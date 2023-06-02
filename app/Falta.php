<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{
    protected $table = 'faltas';

    public function empleados()
    {
    	return $this->belongsToMany(Empleado::class, 'empleado_falta', 'falta_id', 'empleado_id');
    }
}
