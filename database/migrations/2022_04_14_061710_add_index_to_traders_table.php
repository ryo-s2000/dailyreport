<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToTradersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->string('name', 512)->change();
        });

        Schema::table('traders', function (Blueprint $table) {
            $table->unique(['name', 'department_id'], 'name_and_department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('traders', function (Blueprint $table) {
            $table->dropIndex('name_and_department_id');
        });
    }
}
