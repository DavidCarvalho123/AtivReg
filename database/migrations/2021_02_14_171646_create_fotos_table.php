<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('fotos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_foto',60);
            $table->string('link');
            $table->bigInteger('intervencao_grupo_id')->unsigned()->nullable();
            $table->foreign('intervencao_grupo_id')->references('id')->on('intervencoesgrupos')->nullable();
            $table->bigInteger('intervencao_individuai_id')->unsigned()->nullable();
            $table->foreign('intervencao_individuai_id')->references('id')->on('intervencoesindividuais')->nullable();
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
        Schema::dropIfExists('fotos');
    }
}
