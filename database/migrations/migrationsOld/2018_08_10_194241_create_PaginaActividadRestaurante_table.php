<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaActividadRestauranteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaActividadRestaurante', function (Blueprint $table) {
            $table->increments('id');
            // restaurante 
            $table->integer('restaurante_id')->unsigned();
            $table->foreign('restaurante_id')
            ->references('id')->on('PaginaRestaurantes')
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
        Schema::dropIfExists('PaginaActividadRestaurante');
    }
}
