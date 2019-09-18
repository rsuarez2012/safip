<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaServicios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            // operador
            $table->integer('operador_id')->unsigned();
            $table->foreign('operador_id')
            ->references('id')->on('Operadores')
            ->onDelete('cascade');
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
        Schema::dropIfExists('PaginaServicios');
    }
}
