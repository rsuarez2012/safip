<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtroVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otro_ventas', function (Blueprint $table) {
            $table->increments('id');
            // PROVEEDOR_ID
         $table->integer('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('consolidadores');
            
             $table->enum('tipo',['directa','agencia']);
            // ID  VENTA PAQUETE
            $table->integer('paquete_venta_id')->unsigned();
            $table->foreign('paquete_venta_id')
            ->references('id')->on('paquete_ventas')
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
        Schema::dropIfExists('otro_ventas');
    }
}
