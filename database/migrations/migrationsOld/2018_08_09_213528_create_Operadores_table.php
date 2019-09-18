<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Operadores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresas_id');
            $table->string('nombre');
            $table->string('rif');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->string('web');
            $table->string('descripcion');
            $table->string('user_id');
            $table->string('updated_by');
            // categoria de Operadores
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')
            ->references('id')->on('PaginaCategoriaOperadores')
            ->onDelete('cascade');

            // destino de operador
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
        Schema::dropIfExists('Operadores');
    }
}
