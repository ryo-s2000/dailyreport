<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyreports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('username');
            $table->datetime('date');
            $table->text('amweather');
            $table->text('pmweather');
            $table->text('constructionNumber');
            $table->text('constructionName');
            $table->text('traderName1');
            $table->text('peopleNumber1');
            $table->text('workingTime1');
            $table->text('work1');
            $table->text('traderName2');
            $table->text('peopleNumber2');
            $table->text('workingTime2');
            $table->text('work2');
            $table->text('traderName3');
            $table->text('peopleNumber3');
            $table->text('workingTime3');
            $table->text('work3');
            $table->text('traderName4');
            $table->text('peopleNumber4');
            $table->text('workingTime4');
            $table->text('work4');
            $table->text('traderName5');
            $table->text('peopleNumber5');
            $table->text('workingTime5');
            $table->text('work5');
            $table->text('materialTraderName1');
            $table->text('materialName1');
            $table->text('shapeDimensions1');
            $table->text('quantity1');
            $table->text('unit1');
            $table->text('materialTraderName2');
            $table->text('materialName2');
            $table->text('shapeDimensions2');
            $table->text('quantity2');
            $table->text('unit2');
            $table->text('materialTraderName3');
            $table->text('materialName3');
            $table->text('shapeDimensions3');
            $table->text('quantity3');
            $table->text('unit3');
            $table->text('materialTraderName4');
            $table->text('materialName4');
            $table->text('shapeDimensions4');
            $table->text('quantity4');
            $table->text('unit4');
            $table->text('materialTraderName5');
            $table->text('materialName5');
            $table->text('shapeDimensions5');
            $table->text('quantity5');
            $table->text('unit5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dailyreports');
    }
}
