<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoEncuentrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_encuentros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('latitud');
            $table->string('longitud');
            $table->integer('salida_id')->unsigned();
            $table->foreign('salida_id')
            ->references('id')->on('salidaconfirmadas')
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
        Schema::dropIfExists('punto_encuentros');
    }
}
