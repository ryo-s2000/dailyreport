<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropConstructionNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dailyreports', function (Blueprint $table) {
            $table->dropColumn('constructionNumber');
            $table->dropColumn('constructionName');
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
            $table->text('constructionNumber')->nullable()->after('pmWeather');
            $table->text('constructionName')->nullable()->after('constructionNumber');
        });
    }
}
