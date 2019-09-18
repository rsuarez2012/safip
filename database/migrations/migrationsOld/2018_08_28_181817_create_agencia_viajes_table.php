<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciaViajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencia_viajes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('empresas_id');
            $table->string('nombre');
            $table->string('rif');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->string('web');
            $table->string('descripcion');
            $table->string('counter');
            $table->string('users_id');
            $table->string('updated_by');
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
        Schema::dropIfExists('agencia_viajes');
    }
}
