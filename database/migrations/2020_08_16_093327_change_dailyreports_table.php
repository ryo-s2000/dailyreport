<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDailyreportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->integer('department_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->text('department_id')->change();
        });
    }
}
