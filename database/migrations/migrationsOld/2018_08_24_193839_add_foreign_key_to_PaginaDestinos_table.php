<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToPaginaDestinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PaginaDestinos', function (Blueprint $table) {
            /*$table->integer('pais_id')->unsigned()->after('nombre')->index('paginadestinos_pais_id_foreign');

            //Relations
            $table->foreign('pais_id')->references('id')
            ->on('paises')
            ->onUpdate('CASCADE')
            ->onDelete('CASCADE');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PaginaDestinos', function (Blueprint $table) {
            //$table->dropForeign('PaginaDestinos_pais_id_foreign');
        });
    }
}
