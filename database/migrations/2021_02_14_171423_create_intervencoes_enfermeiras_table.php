<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervencoesEnfermeirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('intervencoes_enfermeiras', function (Blueprint $table) {
            $table->string('id',7);
            $table->primary('id');
            $table->tinyInteger('alimentacao');
            $table->tinyInteger('sono');
            $table->tinyInteger('higiene');
            $table->text('notas');
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
        Schema::dropIfExists('intervencoes_enfermeiras');
    }
}
