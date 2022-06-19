<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHiddenAtToConstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->datetime('hidden_at')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->dropColumn('hidden_at');
        });
    }
};
