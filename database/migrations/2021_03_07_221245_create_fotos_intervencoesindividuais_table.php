<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosIntervencoesindividuaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('fotos_intervencoesindividuais', function (Blueprint $table){
            $table->id();
            $table->BigInteger('fotos_id')->unsigned();
            $table->BigInteger('intervencoesindividuai_id')->unsigned();
            $table->timestamps();
            $table->foreign('fotos_id')->references('id')->on('fotos')->onDelete('cascade');
            $table->foreign('intervencoesindividuai_id')->references('id')->on('intervencoesindividuais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fotos_intervencoesindividuais');
    }
}
