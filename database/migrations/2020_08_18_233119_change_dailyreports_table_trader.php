<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDailyreportsTableTrader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->integer('laborTraderId1')->change();
            $table->integer('laborTraderId2')->change();
            $table->integer('laborTraderId3')->change();
            $table->integer('laborTraderId4')->change();
            $table->integer('laborTraderId5')->change();
            $table->integer('laborTraderId6')->change();
            $table->integer('laborTraderId7')->change();
            $table->integer('laborTraderId8')->change();
            $table->integer('heavyMachineryTraderId1')->change();
            $table->integer('heavyMachineryTraderId2')->change();
            $table->integer('heavyMachineryTraderId3')->change();
            $table->integer('heavyMachineryTraderId4')->change();
            $table->integer('heavyMachineryTraderId5')->change();
            $table->integer('heavyMachineryTraderId6')->change();
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
            $table->text('laborTraderId1')->change();
            $table->text('laborTraderId2')->change();
            $table->text('laborTraderId3')->change();
            $table->text('laborTraderId4')->change();
            $table->text('laborTraderId5')->change();
            $table->text('laborTraderId6')->change();
            $table->text('laborTraderId7')->change();
            $table->text('laborTraderId8')->change();
            $table->text('heavyMachineryTraderId1')->change();
            $table->text('heavyMachineryTraderId2')->change();
            $table->text('heavyMachineryTraderId3')->change();
            $table->text('heavyMachineryTraderId4')->change();
            $table->text('heavyMachineryTraderId5')->change();
            $table->text('heavyMachineryTraderId6')->change();
        });
    }
}
