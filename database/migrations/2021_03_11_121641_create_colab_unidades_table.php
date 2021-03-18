<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColabUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('colab_unidades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('colaboradore_id')->unsigned();
            $table->string('unidades_id',6);
            $table->timestamps();
            $table->foreign('colaboradore_id')->references('id')->on('colaboradores')->onDelete('cascade');
            $table->foreign('unidades_id')->references('id')->on('unidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colab_unidades');
    }
}
