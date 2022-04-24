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
            $table->string('number');
            $table->text('name');
            $table->text('orderer')->nullable();
            $table->integer('price')->default(0);
            $table->text('place')->nullable();
            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
            $table->text('sales')->nullable();
            $table->text('supervisor')->nullable();
            $table->text('remarks')->nullable();
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
