<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('nome',70);
            $table->string('apelido',70)->nullable();
            $table->foreignId('niveis_id')->constrained()->nullable();
            $table->boolean('IsDeleted');
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
        Schema::dropIfExists('colaboradores');
    }
}
