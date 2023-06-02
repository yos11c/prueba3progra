<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autoparte extends Model
{
    protected $table = 'autopartes'; // Nombre de la tabla

    public function ventas()
    {
    	return $this->belongsToMany(Ventas::class, 'venta_autoparte', 'autoparte_id', 'venta_id')
    				->withPivot('venta_id', 'cantidad');	
    }
}
