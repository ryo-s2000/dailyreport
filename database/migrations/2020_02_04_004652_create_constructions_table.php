<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('constructions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('number');
            $table->text('name');
            $table->text('orderer');
            $table->integer('price');
            $table->text('place');
            $table->datetime('start');
            $table->datetime('end');
            $table->text('sales');
            $table->text('supervisor');
            $table->text('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('constructions');
    }
}
