<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancoPagoPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banco_pago_paquetes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('banco_emisor');
            $table->string('banco_receptor');
            $table->string('numero_operacion');
            // PAQUETE BONOS ID
            // PAQUETE VENTA ID
          $table->integer('paquete_abono_id')->unsigned();
          $table->foreign('paquete_abono_id')->references('id')->on('paquete_abonos')->onDelete('cascade'); 
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
        Schema::dropIfExists('banco_pago_paquetes');
    }
}
