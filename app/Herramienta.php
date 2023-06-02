<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    protected $table = 'herramientas'; // Nombre de la tabla

    public function cajaHerramientas()
    {
    	return $this->belongsToMany(CajaHerramienta::class, 'herramienta_caja', 'herramienta_id', 'caja_id')
    		->withPivot('caja_id', 'cantidad');
    }
}
