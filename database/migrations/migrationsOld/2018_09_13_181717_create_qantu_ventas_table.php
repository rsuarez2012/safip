<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQantuVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qantu_ventas', function (Blueprint $table) {
         $table->increments('id');
         $table->string('codigo_enlace');
         $table->enum('tipo_pasajero',['Adulto','Ninio']);
         $table->enum('tipo_habitacion',['Simple','Doble','Triple']);
         $table->enum('tipo',['Directa','Agencia']);
         $table->float('porcentaje');
         $table->float('comision');
            // PAQUETE ID
         $table->integer('paquete_id')->unsigned();
         $table->foreign('paquete_id')->references('id')->on('paginapaquetes')->onDelete('cascade');
          // PAQUETE VENTA ID
          $table->integer('paquete_venta_id')->unsigned();
          $table->foreign('paquete_venta_id')->references('id')->on('paquete_ventas')->onDelete('cascade'); 
            
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
        Schema::dropIfExists('qantu_ventas');
    }
}
