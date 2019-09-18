<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaDestinosPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaDestinosPaquetes', function (Blueprint $table) {
            $table->increments('id');
             // noches
            $table->integer('noche_id')->unsigned();
            $table->foreign('noche_id')
            ->references('id')->on('PaginaNoches')
            ->onDelete('cascade');
            // paquetes
            $table->integer('paquete_id')->unsigned();
            $table->foreign('paquete_id')
            ->references('id')->on('PaginaPaquetes')
            ->onDelete('cascade');
           // destinos
            $table->integer('destino_id')->unsigned();
            $table->foreign('destino_id')
            ->references('id')->on('PaginaDestinos')
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
        Schema::dropIfExists('PaginaDestinosPaquetes');
    }
}
