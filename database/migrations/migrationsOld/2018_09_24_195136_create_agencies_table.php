<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('business_name');
            $table->string('legal_representative');
            $table->string('district');
            $table->string('website');
            $table->date('date');
            $table->string('corporate_phone');
            $table->string('user_phone');
            $table->enum('status',['approved','processing','rejected']);
            $table->integer('user_web_id')->unsigned();
            $table->foreign('user_web_id')->references('id')->on('user_webs')
                                          ->onDelete('cascade')
                                          ->onUpdate('cascade');
            $table->string("message")->nullable();
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
        Schema::dropIfExists('agencies');
    }
}
