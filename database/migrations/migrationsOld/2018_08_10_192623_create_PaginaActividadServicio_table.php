<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaActividadServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaActividadServicio', function (Blueprint $table) {
            $table->increments('id');
            // servicio 
            $table->integer('servicio_id')->unsigned();
            $table->foreign('servicio_id')
            ->references('id')->on('PaginaServicios')
            ->onDelete('cascade');
            // actividad 
            $table->integer('actividad_id')->unsigned();
            $table->foreign('actividad_id')
            ->references('id')->on('PaginaActividades')
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
        Schema::dropIfExists('PaginaActividadServicio');
    }
}
