<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingDateToConstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->datetime('billing_date1')->nullable()->after('billing_date');
            $table->datetime('billing_date2')->nullable()->after('billing_date1');
            $table->datetime('billing_date3')->nullable()->after('billing_date2');
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
            $table->dropColumn('billing_date1');
            $table->dropColumn('billing_date2');
            $table->dropColumn('billing_date3');
        });
    }
};
