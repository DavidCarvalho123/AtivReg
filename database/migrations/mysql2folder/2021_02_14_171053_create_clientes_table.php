<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome',70);
            $table->string('apelido',70);
            $table->date('data_entrou');
            $table->string('notas');
            $table->string('foto')->nullable();
            $table->string('unidades_id',6);
            $table->foreign('unidades_id')->references('id')->on('unidades');
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
        Schema::dropIfExists('clientes');
    }
}
