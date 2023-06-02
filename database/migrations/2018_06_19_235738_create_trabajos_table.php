<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
           // $table->integer('empleado_id')->unsigned()->nullable();
           // $table->foreign('empleado_id')->references('id')->on('empleados'); //No sé porque, pero, funcionó para
                                                                               //hacer una llave foránea 
            $table->text('descripcion')->nullable();
            $table->date('fechaLlegada')->nullable();
            $table->date('fechaInicio')->nullable();
            $table->date('fechaFinal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos');
    }
}
