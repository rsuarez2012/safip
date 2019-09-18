<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaPaquetes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->enum('estado',['visible','oculto','destacado'])->default('oculto');
            $table->enum('tipo_tarifa',['neto','doce','diez'])->default('diez');
            $table->double('precio_sol');
            $table->double('precio_dolar');
            $table->string('descripcion');
            $table->string('extracto');
            $table->string('imagen');
            // ESTADO DE CREACION DE PAQUETE
            $table->enum('statusCreado', ['2', '3', '4', 'terminado'])->default('2');
            // CATEGOIA DE PAQUETES
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')
            ->references('id')->on('PaginaCategoriaPaquetes')
            ->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('PaginaPaquetes');
    }
}
