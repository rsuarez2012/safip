<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaRestaurantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaRestaurantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            // peruano
            $table->integer('peruano_id')->unsigned();
            $table->foreign('peruano_id')
            ->references('id')->on('PaginaPeruanos')
            ->onDelete('cascade');
            // comunidad
            $table->integer('comunidad_id')->unsigned();
            $table->foreign('comunidad_id')
            ->references('id')->on('PaginaComunidades')
            ->onDelete('cascade');
            // extranjero
            $table->integer('extranjero_id')->unsigned();
            $table->foreign('extranjero_id')
            ->references('id')->on('PaginaExtranjeros')
            ->onDelete('cascade');
            // destino 
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
        Schema::dropIfExists('PaginaRestaurantes');
    }
}
