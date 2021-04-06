<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesIntervencoesgruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('clientes_intervencoesgrupos', function (Blueprint $table){
            $table->id();
            $table->BigInteger('cliente_id')->unsigned();
            $table->BigInteger('intervencoesgrupo_id')->unsigned();
            $table->timestamps();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
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
        Schema::dropIfExists('clientes_intervencoesgrupos');
    }
}
