<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = 'ventas'; // Nombre de la tabla

    public function motores()
    {
    	return $this->belongsToMany(Motor::class, 'venta_motor', 'venta_id', 'motor_id')
    				->withPivot('motor_id', 'cantidad');
    }

    public function transmisiones()
    {
    	return $this->belongsToMany(Transmision::class, 'venta_transmision', 'venta_id', 'transmision_id')
    				->withPivot('transmision_id', 'cantidad');
    }

    public function autopartes()
    {
        return $this->belongsToMany(Autoparte::class, 'venta_autoparte', 'venta_id', 'autoparte_id')
                    ->withPivot('autoparte_id', 'cantidad');
    }

}
