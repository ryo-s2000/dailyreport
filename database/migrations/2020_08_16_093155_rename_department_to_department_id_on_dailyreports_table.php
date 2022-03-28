<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDepartmentToDepartmentIdOnDailyreportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('department', 'department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->renameColumn('department_id', 'department');
        });
    }
}
