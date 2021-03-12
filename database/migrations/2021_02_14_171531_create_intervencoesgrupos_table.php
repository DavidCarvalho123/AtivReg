<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervencoesgruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('intervencoesgrupos', function (Blueprint $table) {
            $table->id();
            $table->date('data_realizada');
            $table->time('hora_iniciada')->nullable();
            $table->time('hora_terminada')->nullable();
            $table->string('infoable_id',7);
            $table->string('infoable_type');
            $table->foreignId('grupo_id')->constrained()->nullable();
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
        Schema::dropIfExists('intervencoesgrupos');
    }
}
