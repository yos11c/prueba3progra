<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /*Schema::table('motores', function (Blueprint $table) {
            $table->foreign('venta_id')->references('id')->on('ventas');
        });*/

        /*Schema::table('caja_herramientas', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('empleados');
            $table->foreign('user_id2')->references('id')->on('empleados');
        });*/

        /*Schema::table('ventas', function (Blueprint $table) {
            //$table->foreign('motor_id')->references('id')->on('motores');
            $table->foreign('transmision_id')->references('id')->on('transmisiones');
            $table->foreign('autoparte_id')->references('id')->on('autopartes');
        });

        Schema::table('transmisiones', function (Blueprint $table) {
            $table->foreign('venta_id')->references('id')->on('ventas');
        });

        Schema::table('autopartes', function (Blueprint $table) {
            $table->foreign('venta_id')->references('id')->on('ventas');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('herramientas', function (Blueprint $table) {
            $table->dropForeign('herramientas_caja_id_foreign');
        });
        Schema::table('caja_herramientas', function (Blueprint $table) {
            $table->dropForeign('caja_herramientas_user_id_foreign');
            $table->dropForeign('caja_herramientas_user_id2_foreign');
        });
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropForeign('ventas_motor_id_foreign');
            $table->dropForeign('ventas_transmision_id_foreign');
            $table->dropForeign('ventas_autoparte_id_foreign');
        });
        /*Schema::table('historial', function (Blueprint $table) {
            $table->dropForeign('historial_user_id_foreign');
        });*/
        Schema::table('trabajos', function (Blueprint $table) {
            $table->dropForeign('trabajos_empleado_id_foreign');
        });
    }
}
