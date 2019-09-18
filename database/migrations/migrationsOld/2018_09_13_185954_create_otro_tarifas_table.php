<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtroTarifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otro_tarifas', function (Blueprint $table) {
            $table->increments('id');
             // ID PAQUETE TARIFA VENTA
             $table->integer('paquete_tarifa_venta_id')->unsigned();
            $table->foreign('paquete_tarifa_venta_id')
            ->references('id')->on('paquete_tarifa_ventas')
            ->onDelete('cascade');
             // ID OTROS VENTAS
            $table->integer('otro_venta_id')->unsigned();
            $table->foreign('otro_venta_id')
            ->references('id')->on('otro_ventas')
            ->onDelete('cascade');
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
        Schema::dropIfExists('otro_tarifas');
    }
}
