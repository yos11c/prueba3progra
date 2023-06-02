<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutopartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autopartes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('parte');
            $table->string('modelo');
            $table->integer('cantidad');
            $table->string('marca');
            $table->float('costo');
            $table->string('moneda');
            $table->string('descripcion')->nullable();
            $table->text('modelosDisponibles');
            $table->string('palancaCambios')->nullable();
            $table->integer('cilindros')->nullable();
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
        Schema::dropIfExists('autopartes');
    }
}
