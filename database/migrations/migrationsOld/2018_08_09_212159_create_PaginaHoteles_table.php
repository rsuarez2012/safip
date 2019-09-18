<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginaHotelesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PaginaHoteles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('estrella');
            $table->double('e_swb');
            $table->double('e_dwb');
            $table->double('e_tpl');
            $table->double('e_chd');
            $table->double('p_swb');
            $table->double('p_dwb');
            $table->double('p_tpl');
            $table->double('p_chd');
            $table->string('enlace');
            $table->time('check_in');
            $table->time('check_out');
            // destino 
            $table->integer('destino_id')->unsigned();
            $table->foreign('destino_id')
            ->references('id')->on('PaginaDestinos')
            ->onDelete('cascade');
            // categoria paquete 
            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')
            ->references('id')->on('PaginaCategoriaHoteles')
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
        Schema::dropIfExists('PaginaHoteles');
    }
}
