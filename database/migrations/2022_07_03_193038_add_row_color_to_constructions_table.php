<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRowColorToConstructionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->string('row_color')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->dropColumn('row_color');
        });
    }
}
