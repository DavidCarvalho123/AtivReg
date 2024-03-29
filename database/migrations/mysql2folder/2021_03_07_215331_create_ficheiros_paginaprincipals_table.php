<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicheirosPaginaprincipalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('ficheiros_paginaprincipals', function (Blueprint $table){
            $table->id();
            $table->BigInteger('ficheiros_id')->unsigned();
            $table->BigInteger('pagina__principal_id')->unsigned();
            $table->timestamps();
            $table->foreign('ficheiros_id')->references('id')->on('ficheiros')->onDelete('cascade');
            $table->foreign('pagina__principal_id')->references('id')->on('pagina__principals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ficheiros_paginaprincipals');
    }
}
