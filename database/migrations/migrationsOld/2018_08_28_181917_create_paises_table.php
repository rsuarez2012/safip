<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('PaisCodigo');
            $table->string('Paisnombre');
            $table->string('PaisContinente');
            $table->string('PaisRegion');
            $table->string('PaisArea');
            $table->string('PaisIndependecia');
            $table->string('PaisPoblacion');
            $table->string('PaisExpectativaDeVida');
            $table->string('PaisProductoInternoBruto');
            $table->string('PaisProductoInternoBrutoAntiguo');
            $table->string('PaisNombreLocal');
            $table->string('PaisGobierno');
            $table->string('PaisJefeDeEstado');
            $table->string('PaisCapital');
            $table->string('PaisCodigo2');
            $table->string('users_id');
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
        Schema::dropIfExists('paises');
    }
}
