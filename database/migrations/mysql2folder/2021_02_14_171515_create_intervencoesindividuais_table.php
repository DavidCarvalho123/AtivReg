<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervencoesindividuaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('intervencoesindividuais', function (Blueprint $table) {
            $table->id();
            $table->date('data_realizada');
            $table->time('hora_iniciada')->nullable();
            $table->time('hora_terminada')->nullable();
            $table->foreignId('cliente_id')->constrained();
            $table->bigInteger('colaborador_id')->unsigned();
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
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
        Schema::dropIfExists('intervencoesindividuais');
    }
}
