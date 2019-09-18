<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaqueteAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete_abonos', function (Blueprint $table) {
            $table->increments('id');
            $table->float('monto');
            $table->enum('tipo_pago',['Efectivo','TDO','TDC','Cheque','Transferencia','Deposito','Credito']);
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
        Schema::dropIfExists('paquete_abonos');
    }
}
