<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervencoesEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervencoesentidades', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('intervencoes_entidades');
    }
}
