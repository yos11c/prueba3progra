<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHerramientaCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('herramienta_caja', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('herramienta_id')->unsigned();
            $table->integer('caja_id')->unsigned();
            $table->integer('cantidad')->unsigned()->nullable();

            $table->foreign('herramienta_id')->references('id')->on('herramientas');
            $table->foreign('caja_id')->references('id')->on('caja_herramientas');

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
        Schema::dropIfExists('herramienta_caja');
    }
}
