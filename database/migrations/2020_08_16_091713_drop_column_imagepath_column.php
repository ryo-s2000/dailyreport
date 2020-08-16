<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnImagepathColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->dropColumn('imagepath1');
            $table->dropColumn('imagepath2');
            $table->dropColumn('imagepath3');
            $table->dropColumn('imagepath4');
            $table->dropColumn('imagepath5');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->text('imagepath1');
            $table->text('imagepath2');
            $table->text('imagepath3');
            $table->text('imagepath4');
            $table->text('imagepath5');
        });
    }
}
