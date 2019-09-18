<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaDatosPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaDatosPaquetes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('texto');
            $table->enum('tipo', ['incluido', 'noincluido', 'llevar', 'importante', 'politcareserva','politicatarifa','fechas','responsabilidades']);
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
        Schema::dropIfExists('PaginaDatosPaquetes');
    }
}
