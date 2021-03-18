<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColabIntervencoesgruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('colab_intervencoesgrupos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('colaboradore_id')->unsigned();
            $table->bigInteger('intervencoesgrupo_id')->unsigned();
            $table->timestamps();
            $table->foreign('colaboradore_id')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->foreign('intervencoesgrupo_id')->references('id')->on('intervencoesgrupos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colab_intervencoesgrupos');
    }
}
