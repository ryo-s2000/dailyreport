<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnImagepathColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->dropColumn('imagepath1');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->dropColumn('imagepath2');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->dropColumn('imagepath3');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->dropColumn('imagepath4');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->dropColumn('imagepath5');
        });
    }

    /**
     * Reverse the migrations.
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
