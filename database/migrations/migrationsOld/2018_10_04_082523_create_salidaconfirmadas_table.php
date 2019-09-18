<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalidaconfirmadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salidaconfirmadas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_salida');
            $table->date('fecha_llegada');
            $table->integer('cupos');
            // paquetes
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
        Schema::dropIfExists('salidaconfirmadas');
    }
}
