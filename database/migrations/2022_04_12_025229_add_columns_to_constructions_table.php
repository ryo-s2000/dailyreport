<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToConstructionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->string('year')->index()->default('')->after('id');
            $table->string('scale')->nullable()->after('number');
            $table->integer('progress')->default(0)->after('scale');
            $table->datetime('billing_date')->nullable()->after('progress');
            $table->datetime('payment_date')->nullable()->after('billing_date');
            $table->datetime('contract_date')->nullable()->after('orderer');
            $table->integer('score')->nullable()->after('contract_date');
            $table->integer('price_spare1')->nullable()->after('price');
            $table->integer('price_spare2')->nullable()->after('price_spare1');
            $table->integer('price_spare3')->nullable()->after('price_spare2');
            $table->integer('price_spare4')->nullable()->after('price_spare3');
            $table->datetime('period_spare1')->nullable()->after('end');
            $table->datetime('period_spare2')->nullable()->after('period_spare1');
            $table->datetime('period_spare3')->nullable()->after('period_spare2');
            $table->datetime('period_spare4')->nullable()->after('period_spare3');
            $table->string('agent')->default('')->after('supervisor');
            $table->string('developer')->default('')->after('agent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('constructions', function (Blueprint $table) {
            $table->dropColumn('year');
            $table->dropColumn('scale');
            $table->dropColumn('progress');
            $table->dropColumn('billing_date');
            $table->dropColumn('payment_date');
            $table->dropColumn('contract_date');
            $table->dropColumn('score');
            $table->dropColumn('price_spare1');
            $table->dropColumn('price_spare2');
            $table->dropColumn('price_spare3');
            $table->dropColumn('price_spare4');
            $table->dropColumn('period_spare1');
            $table->dropColumn('period_spare2');
            $table->dropColumn('period_spare3');
            $table->dropColumn('period_spare4');
            $table->dropColumn('agent');
            $table->dropColumn('developer');
        });
    }
}
