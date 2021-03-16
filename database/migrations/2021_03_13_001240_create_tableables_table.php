<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('tableables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nivei_id')->unsigned();
            $table->string('tableable_id',7);
            $table->string('tableable_type');
            $table->foreign('nivei_id')->references('id')->on('niveis')->onDelete('cascade');
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
        Schema::dropIfExists('tableables');
    }
}
