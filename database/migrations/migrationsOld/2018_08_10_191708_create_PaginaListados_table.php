<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaListadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaListados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->enum('estado',['visible','oculto'])->default('oculto');
            // noches
            $table->integer('noche_id')->unsigned();
            $table->foreign('noche_id')
            ->references('id')->on('PaginaNoches')
            ->onDelete('cascade');
            // hotel
            $table->integer('hotel_id')->unsigned();
            $table->foreign('hotel_id')
            ->references('id')->on('PaginaHoteles')
            ->onDelete('cascade');
            // destinos paquetes
            $table->integer('paquete_id')->unsigned();
            $table->foreign('paquete_id')
            ->references('id')->on('PaginaPaquetes')
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
        Schema::dropIfExists('PaginaListados');
    }
}
