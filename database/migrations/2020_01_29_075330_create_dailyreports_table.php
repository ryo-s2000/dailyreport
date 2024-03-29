<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyreportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dailyreports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('userName');
            $table->text('department');
            $table->datetime('date');
            $table->text('amWeather');
            $table->text('pmWeather');
            $table->text('constructionNumber');
            $table->text('constructionName');
            $table->text('laborTraderName1');
            $table->text('laborPeopleNumber1');
            $table->text('laborWorkTime1');
            $table->text('laborWorkVolume1');
            $table->text('laborTraderName2');
            $table->text('laborPeopleNumber2');
            $table->text('laborWorkTime2');
            $table->text('laborWorkVolume2');
            $table->text('laborTraderName3');
            $table->text('laborPeopleNumber3');
            $table->text('laborWorkTime3');
            $table->text('laborWorkVolume3');
            $table->text('laborTraderName4');
            $table->text('laborPeopleNumber4');
            $table->text('laborWorkTime4');
            $table->text('laborWorkVolume4');
            $table->text('laborTraderName5');
            $table->text('laborPeopleNumber5');
            $table->text('laborWorkTime5');
            $table->text('laborWorkVolume5');
            $table->text('laborTraderName6');
            $table->text('laborPeopleNumber6');
            $table->text('laborWorkTime6');
            $table->text('laborWorkVolume6');
            $table->text('laborTraderName7');
            $table->text('laborPeopleNumber7');
            $table->text('laborWorkTime7');
            $table->text('laborWorkVolume7');
            $table->text('laborTraderName8');
            $table->text('laborPeopleNumber8');
            $table->text('laborWorkTime8');
            $table->text('laborWorkVolume8');
            $table->text('heavyMachineryTraderName1');
            $table->text('heavyMachineryModel1');
            $table->text('heavyMachineryTime1');
            $table->text('heavyMachineryRemarks1');
            $table->text('heavyMachineryTraderName2');
            $table->text('heavyMachineryModel2');
            $table->text('heavyMachineryTime2');
            $table->text('heavyMachineryRemarks2');
            $table->text('heavyMachineryTraderName3');
            $table->text('heavyMachineryModel3');
            $table->text('heavyMachineryTime3');
            $table->text('heavyMachineryRemarks3');
            $table->text('heavyMachineryTraderName4');
            $table->text('heavyMachineryModel4');
            $table->text('heavyMachineryTime4');
            $table->text('heavyMachineryRemarks4');
            $table->text('heavyMachineryTraderName5');
            $table->text('heavyMachineryModel5');
            $table->text('heavyMachineryTime5');
            $table->text('heavyMachineryRemarks5');
            $table->text('heavyMachineryTraderName6');
            $table->text('heavyMachineryModel6');
            $table->text('heavyMachineryTime6');
            $table->text('heavyMachineryRemarks6');
            $table->text('materialTraderName1');
            $table->text('materialName1');
            $table->text('materialShapeDimensions1');
            $table->text('materialQuantity1');
            $table->text('materialUnit1');
            $table->text('materialResult1');
            $table->text('materialInspectionMethods1');
            $table->text('materialInspector1');
            $table->text('materialTraderName2');
            $table->text('materialName2');
            $table->text('materialShapeDimensions2');
            $table->text('materialQuantity2');
            $table->text('materialUnit2');
            $table->text('materialResult2');
            $table->text('materialInspectionMethods2');
            $table->text('materialInspector2');
            $table->text('materialTraderName3');
            $table->text('materialName3');
            $table->text('materialShapeDimensions3');
            $table->text('materialQuantity3');
            $table->text('materialUnit3');
            $table->text('materialResult3');
            $table->text('materialInspectionMethods3');
            $table->text('materialInspector3');
            $table->text('materialTraderName4');
            $table->text('materialName4');
            $table->text('materialShapeDimensions4');
            $table->text('materialQuantity4');
            $table->text('materialUnit4');
            $table->text('materialResult4');
            $table->text('materialInspectionMethods4');
            $table->text('materialInspector4');
            $table->text('materialTraderName5');
            $table->text('materialName5');
            $table->text('materialShapeDimensions5');
            $table->text('materialQuantity5');
            $table->text('materialUnit5');
            $table->text('materialResult5');
            $table->text('materialInspectionMethods5');
            $table->text('materialInspector5');
            $table->text('processName1');
            $table->text('processLocation1');
            $table->text('processMethods1');
            $table->text('processDocument1');
            $table->text('processResult1');
            $table->text('processInspector1');
            $table->text('processName2');
            $table->text('processLocation2');
            $table->text('processMethods2');
            $table->text('processDocument2');
            $table->text('processResult2');
            $table->text('processInspector2');
            $table->text('processName3');
            $table->text('processLocation3');
            $table->text('processMethods3');
            $table->text('processDocument3');
            $table->text('processResult3');
            $table->text('processInspector3');
            $table->text('processName4');
            $table->text('processLocation4');
            $table->text('processMethods4');
            $table->text('processDocument4');
            $table->text('processResult4');
            $table->text('processInspector4');
            $table->text('measuringEquipmentName1');
            $table->text('measuringEquipmentNumber1');
            $table->text('measuringEquipmentResult1');
            $table->text('measuringEquipmentRemarks1');
            $table->text('measuringEquipmentName2');
            $table->text('measuringEquipmentNumber2');
            $table->text('measuringEquipmentResult2');
            $table->text('measuringEquipmentRemarks2');
            $table->text('imagepath1');
            $table->text('imagepath2');
            $table->text('imagepath3');
            $table->text('imagepath4');
            $table->text('imagepath5');
            $table->text('patrolResult');
            $table->text('patrolFindings');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('dailyreports');
    }
}
