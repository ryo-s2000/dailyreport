<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTraderToDepartmentIdOnDailyreportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName1', 'laborTraderId1');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName2', 'laborTraderId2');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName3', 'laborTraderId3');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName4', 'laborTraderId4');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName5', 'laborTraderId5');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName6', 'laborTraderId6');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName7', 'laborTraderId7');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderName8', 'laborTraderId8');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('heavyMachineryTraderName1', 'heavyMachineryTraderId1');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('heavyMachineryTraderName2', 'heavyMachineryTraderId2');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('heavyMachineryTraderName3', 'heavyMachineryTraderId3');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('heavyMachineryTraderName4', 'heavyMachineryTraderId4');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('heavyMachineryTraderName5', 'heavyMachineryTraderId5');
        });
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('heavyMachineryTraderName6', 'heavyMachineryTraderId6');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('laborTraderId1', 'laborTraderName1');
            $table->renameColumn('laborTraderId2', 'laborTraderName2');
            $table->renameColumn('laborTraderId3', 'laborTraderName3');
            $table->renameColumn('laborTraderId4', 'laborTraderName4');
            $table->renameColumn('laborTraderId5', 'laborTraderName5');
            $table->renameColumn('laborTraderId6', 'laborTraderName6');
            $table->renameColumn('laborTraderId7', 'laborTraderName7');
            $table->renameColumn('laborTraderId8', 'laborTraderName8');
            $table->renameColumn('heavyMachineryTraderId1', 'heavyMachineryTraderName1');
            $table->renameColumn('heavyMachineryTraderId2', 'heavyMachineryTraderName2');
            $table->renameColumn('heavyMachineryTraderId3', 'heavyMachineryTraderName3');
            $table->renameColumn('heavyMachineryTraderId4', 'heavyMachineryTraderName4');
            $table->renameColumn('heavyMachineryTraderId5', 'heavyMachineryTraderName5');
            $table->renameColumn('heavyMachineryTraderId6', 'heavyMachineryTraderName6');
        });
    }
}
