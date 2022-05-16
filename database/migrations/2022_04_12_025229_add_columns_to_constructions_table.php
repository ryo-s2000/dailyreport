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
            $table->string('year')->default('')->after('id');
            $table->string('scale')->nullable()->after('number');
            $table->json('progress')->after('scale');
            $table->datetime('contract_date')->nullable()->after('progress');
            $table->datetime('billing_date')->nullable()->after('contract_date');
            $table->datetime('payment_date')->nullable()->after('billing_date');
            $table->integer('score')->nullable()->after('payment_date');
            $table->integer('tax')->default(0)->after('price');
            $table->integer('price_spare1')->nullable()->after('tax');
            $table->integer('price_spare2')->nullable()->after('price_spare1');
            $table->integer('price_spare3')->nullable()->after('price_spare2');
            $table->integer('price_spare4')->nullable()->after('price_spare3');
            $table->datetime('period_spare1')->nullable()->after('end');
            $table->datetime('period_spare2')->nullable()->after('period_spare1');
            $table->datetime('period_spare3')->nullable()->after('period_spare2');
            $table->datetime('period_spare4')->nullable()->after('period_spare3');
            $table->string('agent')->nullable()->after('supervisor');
            $table->string('developer')->nullable()->after('agent');

            $table->unique(['year', 'number'], 'year_and_number');
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
            $table->dropColumn('contract_date');
            $table->dropColumn('billing_date');
            $table->dropColumn('payment_date');
            $table->dropColumn('score');
            $table->dropColumn('tax');
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

            $table->dropIndex('year_and_number');
        });
    }
}
