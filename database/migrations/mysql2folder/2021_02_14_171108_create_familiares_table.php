<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('familiares', function (Blueprint $table)
        {
            $table->id();
            $table->string('nome',70);
            $table->string('apelido',70);
            $table->string('nome_utilizador');
            $table->string('password');
            $table->integer('nr_telefone')->length(9)->unsigned()->nullable();
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
        Schema::dropIfExists('familiares');
    }
}
