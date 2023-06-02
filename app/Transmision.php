<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transmision extends Model
{
    protected $table = 'transmisiones'; // Nombre de la tabla

    public function ventas()
    {
    	return $this->belongsToMany(Ventas::class, 'venta_transmision', 'transmision_id', 'venta_id')
    				->withPivot('transmision_id', 'cantidad');	
    }
}
