<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColabIntervencoesindividuaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('colab_intervencoesindividuais', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('colaboradore_id')->unsigned();
            $table->bigInteger('intervencoesindividuai_id')->unsigned();
            $table->timestamps();
            $table->foreign('colaboradore_id')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->foreign('intervencoesindividuai_id')->references('id')->on('intervencoesindividuais')->onDelete('cascade');        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colab_intervencoesindividuais');
    }
}
