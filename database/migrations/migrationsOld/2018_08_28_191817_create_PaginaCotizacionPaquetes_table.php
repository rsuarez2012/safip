<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaCotizacionPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaCotizacionPaquetes', function (Blueprint $table) {
            $table->increments('id');
            // AGENCIA DE VIAJES
            $table->integer('agencia_id')->unsigned();
            $table->foreign('agencia_id')
            ->references('id')->on('agencia_viajes')
            ->onDelete('cascade');
            // PAIS 
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')
            ->references('id')->on('paises')
            ->onDelete('cascade');
            // DESTINO 
            $table->integer('destino_id')->unsigned();
            $table->foreign('destino_id')
            ->references('id')->on('paginadestinos')
            ->onDelete('cascade');
                
            $table->date('fecha_salida');
            $table->date('fecha_retorno');
            $table->integer('pasajero');
            $table->enum('estado',['procesado','por_procesar','anulado'])->default('por_procesar');
            $table->integer('user_id')->unsigned();
            $table->enum('nacionalidad',['extranjero','peruano','comunidad']);
            $table->string('observacion')->nulable()->default('Sin Observaciones');
            $table->float('por_pagar')->default(0);
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
        Schema::dropIfExists('PaginaCotizacionPaquetes');
    }
}
