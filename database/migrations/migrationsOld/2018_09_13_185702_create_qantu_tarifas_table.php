<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQantuTarifasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qantu_tarifas', function (Blueprint $table) {
            $table->increments('id');
             // ID QANTU VENTAS
            $table->integer('qantu_venta_id')->unsigned();
            $table->foreign('qantu_venta_id')
            ->references('id')->on('qantu_ventas')
            ->onDelete('cascade');
            // ID PAQUETE TARIFA VENTA
             $table->integer('paquete_tarifa_venta_id')->unsigned();
            $table->foreign('paquete_tarifa_venta_id')
            ->references('id')->on('paquete_tarifa_ventas')
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
        Schema::dropIfExists('qantu_tarifas');
    }
}
