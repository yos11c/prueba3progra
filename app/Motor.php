<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    protected $table = 'motores'; // Nombre de la tabla

    public function ventas()
    {
    	return $this->belongsToMany(Ventas::class, 'venta_motor', 'motor_id', 'venta_id')
    				->withPivot('venta_id', 'cantidad');	
    }
}
