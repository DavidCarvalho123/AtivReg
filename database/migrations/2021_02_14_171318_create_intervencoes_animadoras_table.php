<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervencoesAnimadorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('intervencoes_animadoras', function (Blueprint $table) {
            // id será string e com nomencultura as 3 primeiras letras, ou seja, id = ani1.
            $table->string('id',7);
            $table->primary('id');
            $table->text('atividades');
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
        Schema::dropIfExists('intervencoes_animadoras');
    }
}
