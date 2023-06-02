<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('servicio');
            $table->float('costo');
            $table->string('moneda');
            $table->string('nombreCliente');
            $table->string('apellidoCliente');
            $table->string('telCliente');
            $table->text('carro');
            $table->date('fecha');
            $table->date('fechaSiguiente')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('agendada')->default(false)->nullable();
            $table->boolean('finalizado')->default(false)->nullable();
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
        Schema::dropIfExists('servicios');
    }
}
