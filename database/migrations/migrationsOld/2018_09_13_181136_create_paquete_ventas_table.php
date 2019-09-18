<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaqueteVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('nacionalidad',['Peruano','Comunidad','Extranjero']);
            $table->string('costo_neto');
            $table->string('incentivo');
            

            // VENDEDOR_ID
             $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

            // CLIENTE ID
            $table->integer('cliente_id')->unsigned();
            
            // COTIZACION ID
            $table->integer('cotizacion_id')->unsigned();
            $table->foreign('cotizacion_id')
            ->references('id')->on('PaginaCotizacionPaquetes')
            ->onDelete('cascade');

            $table->float('total_venta');
            $table->float('a_pagar');
            $table->enum('estado',['Cancelado','Pendiente'])->default('Pendiente');
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
        Schema::dropIfExists('paquete_ventas');
    }
}
