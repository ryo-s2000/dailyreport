<?php

namespace App\Http\Controllers;

use App\Dailyreport;
use App\Construction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function newReport(){
        $constructions = Construction::all();
        $datetime = date("Y-m-d");
        return view('newreport', ['datetime' => $datetime, "constructions" => $constructions]);
    }

    public function saveReport(Request $request){
        $dailyreport = new Dailyreport;
        // ユーザー情報
        $dailyreport->userName = $request->userName ?? '';
        $dailyreport->department = $request->department ?? '';

        // 日付
        $dailyreport->date = $request->date ?? '';

        // 天気
        $dailyreport->amWeather = $request->amWeather ?? '';
        $dailyreport->pmWeather = $request->pmWeather ?? '';

        // 工事番号・工事名
        $dailyreport->constructionNumber = $request->constructionNumber ?? '';
        $dailyreport->constructionName = $request->constructionName ?? '';

        // 労務
        $dailyreport->laborTraderName1 = $request->laborTraderName1 ?? '';
        $dailyreport->laborPeopleNumber1 = $request->laborPeopleNumber1 ?? '';
        $dailyreport->laborWorkTime1 = $request->laborWorkTime1 ?? '';
        $dailyreport->laborWorkVolume1 = $request->laborWorkVolume1 ?? '';
        $dailyreport->laborTraderName2 = $request->laborTraderName2 ?? '';
        $dailyreport->laborPeopleNumber2 = $request->laborPeopleNumber2 ?? '';
        $dailyreport->laborWorkTime2 = $request->laborWorkTime2 ?? '';
        $dailyreport->laborWorkVolume2 = $request->laborWorkVolume2 ?? '';
        $dailyreport->laborTraderName3 = $request->laborTraderName3 ?? '';
        $dailyreport->laborPeopleNumber3 = $request->laborPeopleNumber3 ?? '';
        $dailyreport->laborWorkTime3 = $request->laborWorkTime3 ?? '';
        $dailyreport->laborWorkVolume3 = $request->laborWorkVolume3 ?? '';
        $dailyreport->laborTraderName4 = $request->laborTraderName4 ?? '';
        $dailyreport->laborPeopleNumber4 = $request->laborPeopleNumber4 ?? '';
        $dailyreport->laborWorkTime4 = $request->laborWorkTime4 ?? '';
        $dailyreport->laborWorkVolume4 = $request->laborWorkVolume4 ?? '';
        $dailyreport->laborTraderName5 = $request->laborTraderName5 ?? '';
        $dailyreport->laborPeopleNumber5 = $request->laborPeopleNumber5 ?? '';
        $dailyreport->laborWorkTime5 = $request->laborWorkTime5 ?? '';
        $dailyreport->laborWorkVolume5 = $request->laborWorkVolume5 ?? '';
        $dailyreport->laborTraderName6 = $request->laborTraderName6 ?? '';
        $dailyreport->laborPeopleNumber6 = $request->laborPeopleNumber6 ?? '';
        $dailyreport->laborWorkTime6 = $request->laborWorkTime6 ?? '';
        $dailyreport->laborWorkVolume6 = $request->laborWorkVolume6 ?? '';
        $dailyreport->laborTraderName7 = $request->laborTraderName7 ?? '';
        $dailyreport->laborPeopleNumber7 = $request->laborPeopleNumber7 ?? '';
        $dailyreport->laborWorkTime7 = $request->laborWorkTime7 ?? '';
        $dailyreport->laborWorkVolume7 = $request->laborWorkVolume7 ?? '';
        $dailyreport->laborTraderName8 = $request->laborTraderName8 ?? '';
        $dailyreport->laborPeopleNumber8 = $request->laborPeopleNumber8 ?? '';
        $dailyreport->laborWorkTime8 = $request->laborWorkTime8 ?? '';
        $dailyreport->laborWorkVolume8 = $request->laborWorkVolume8 ?? '';

        // 重機車両
        $dailyreport->heavyMachineryTraderName1 = $request->heavyMachineryTraderName1 ?? '';
        $dailyreport->heavyMachineryModel1 = $request->heavyMachineryModel1 ?? '';
        $dailyreport->heavyMachineryTime1 = $request->heavyMachineryTime1 ?? '';
        $dailyreport->heavyMachineryRemarks1 = $request->heavyMachineryRemarks1 ?? '';
        $dailyreport->heavyMachineryTraderName2 = $request->heavyMachineryTraderName2 ?? '';
        $dailyreport->heavyMachineryModel2 = $request->heavyMachineryModel2 ?? '';
        $dailyreport->heavyMachineryTime2 = $request->heavyMachineryTime2 ?? '';
        $dailyreport->heavyMachineryRemarks2 = $request->heavyMachineryRemarks2 ?? '';
        $dailyreport->heavyMachineryTraderName3 = $request->heavyMachineryTraderName3 ?? '';
        $dailyreport->heavyMachineryModel3 = $request->heavyMachineryModel3 ?? '';
        $dailyreport->heavyMachineryTime3 = $request->heavyMachineryTime3 ?? '';
        $dailyreport->heavyMachineryRemarks3 = $request->heavyMachineryRemarks3 ?? '';
        $dailyreport->heavyMachineryTraderName4 = $request->heavyMachineryTraderName4 ?? '';
        $dailyreport->heavyMachineryModel4 = $request->heavyMachineryModel4 ?? '';
        $dailyreport->heavyMachineryTime4 = $request->heavyMachineryTime4 ?? '';
        $dailyreport->heavyMachineryRemarks4 = $request->heavyMachineryRemarks4 ?? '';
        $dailyreport->heavyMachineryTraderName5 = $request->heavyMachineryTraderName5 ?? '';
        $dailyreport->heavyMachineryModel5 = $request->heavyMachineryModel5 ?? '';
        $dailyreport->heavyMachineryTime5 = $request->heavyMachineryTime5 ?? '';
        $dailyreport->heavyMachineryRemarks5 = $request->heavyMachineryRemarks5 ?? '';
        $dailyreport->heavyMachineryTraderName6 = $request->heavyMachineryTraderName6 ?? '';
        $dailyreport->heavyMachineryModel6 = $request->heavyMachineryModel6 ?? '';
        $dailyreport->heavyMachineryTime6 = $request->heavyMachineryTime6 ?? '';
        $dailyreport->heavyMachineryRemarks6 = $request->heavyMachineryRemarks6 ?? '';

        // 購入資材
        $dailyreport->materialTraderName1 = $request->materialTraderName1 ?? '';
        $dailyreport->materialName1 = $request->materialName1 ?? '';
        $dailyreport->materialShapeDimensions1 = $request->materialShapeDimensions1 ?? '';
        $dailyreport->materialQuantity1 = $request->materialQuantity1 ?? '';
        $dailyreport->materialUnit1 = $request->materialUnit1 ?? '';
        $dailyreport->materialResult1 = $request->materialResult1 ?? '';
        $dailyreport->materialInspectionMethods1 = $request->materialInspectionMethods1 ?? '';
        $dailyreport->materialInspector1 = $request->materialInspector1 ?? '';
        $dailyreport->materialTraderName2 = $request->materialTraderName2 ?? '';
        $dailyreport->materialName2 = $request->materialName2 ?? '';
        $dailyreport->materialShapeDimensions2 = $request->materialShapeDimensions2 ?? '';
        $dailyreport->materialQuantity2 = $request->materialQuantity2 ?? '';
        $dailyreport->materialUnit2 = $request->materialUnit2 ?? '';
        $dailyreport->materialResult2 = $request->materialResult2 ?? '';
        $dailyreport->materialInspectionMethods2 = $request->materialInspectionMethods2 ?? '';
        $dailyreport->materialInspector2 = $request->materialInspector2 ?? '';
        $dailyreport->materialTraderName3 = $request->materialTraderName3 ?? '';
        $dailyreport->materialName3 = $request->materialName3 ?? '';
        $dailyreport->materialShapeDimensions3 = $request->materialShapeDimensions3 ?? '';
        $dailyreport->materialQuantity3 = $request->materialQuantity3 ?? '';
        $dailyreport->materialUnit3 = $request->materialUnit3 ?? '';
        $dailyreport->materialResult3 = $request->materialResult3 ?? '';
        $dailyreport->materialInspectionMethods3 = $request->materialInspectionMethods3 ?? '';
        $dailyreport->materialInspector3 = $request->materialInspector3 ?? '';
        $dailyreport->materialTraderName4 = $request->materialTraderName4 ?? '';
        $dailyreport->materialName4 = $request->materialName4 ?? '';
        $dailyreport->materialShapeDimensions4 = $request->materialShapeDimensions4 ?? '';
        $dailyreport->materialQuantity4 = $request->materialQuantity4 ?? '';
        $dailyreport->materialUnit4 = $request->materialUnit4 ?? '';
        $dailyreport->materialResult4 = $request->materialResult4 ?? '';
        $dailyreport->materialInspectionMethods4 = $request->materialInspectionMethods4 ?? '';
        $dailyreport->materialInspector4 = $request->materialInspector4 ?? '';
        $dailyreport->materialTraderName5 = $request->materialTraderName5 ?? '';
        $dailyreport->materialName5 = $request->materialName5 ?? '';
        $dailyreport->materialShapeDimensions5 = $request->materialShapeDimensions5 ?? '';
        $dailyreport->materialQuantity5 = $request->materialQuantity5 ?? '';
        $dailyreport->materialUnit5 = $request->materialUnit5 ?? '';
        $dailyreport->materialResult5 = $request->materialResult5 ?? '';
        $dailyreport->materialInspectionMethods5 = $request->materialInspectionMethods5 ?? '';
        $dailyreport->materialInspector5 = $request->materialInspector5 ?? '';

        // 工程内検査
        $dailyreport->processName1 = $request->processName1 ?? '';
        $dailyreport->processLocation1 = $request->processLocation1 ?? '';
        $dailyreport->processMethods1 = $request->processMethods1 ?? '';
        $dailyreport->processDocument1 = $request->processDocument1 ?? '';
        $dailyreport->processResult1 = $request->processResult1 ?? '';
        $dailyreport->processInspector1 = $request->processInspector1 ?? '';
        $dailyreport->processName2 = $request->processName2 ?? '';
        $dailyreport->processLocation2 = $request->processLocation2 ?? '';
        $dailyreport->processMethods2 = $request->processMethods2 ?? '';
        $dailyreport->processDocument2 = $request->processDocument2 ?? '';
        $dailyreport->processResult2 = $request->processResult2 ?? '';
        $dailyreport->processInspector2 = $request->processInspector2 ?? '';
        $dailyreport->processName3 = $request->processName3 ?? '';
        $dailyreport->processLocation3 = $request->processLocation3 ?? '';
        $dailyreport->processMethods3 = $request->processMethods3 ?? '';
        $dailyreport->processDocument3 = $request->processDocument3 ?? '';
        $dailyreport->processResult3 = $request->processResult3 ?? '';
        $dailyreport->processInspector3 = $request->processInspector3 ?? '';
        $dailyreport->processName4 = $request->processName4 ?? '';
        $dailyreport->processLocation4 = $request->processLocation4 ?? '';
        $dailyreport->processMethods4 = $request->processMethods4 ?? '';
        $dailyreport->processDocument4 = $request->processDocument4 ?? '';
        $dailyreport->processResult4 = $request->processResult4 ?? '';
        $dailyreport->processInspector4 = $request->processInspector4 ?? '';

        // 測定機器点検
        $dailyreport->measuringEquipmentName1 = $request->measuringEquipmentName1 ?? '';
        $dailyreport->measuringEquipmentNumber1 = $request->measuringEquipmentNumber1 ?? '';
        $dailyreport->measuringEquipmentResult1 = $request->measuringEquipmentResult1 ?? '';
        $dailyreport->measuringEquipmentRemarks1 = $request->measuringEquipmentRemarks1 ?? '';
        $dailyreport->measuringEquipmentName2 = $request->measuringEquipmentName2 ?? '';
        $dailyreport->measuringEquipmentNumber2 = $request->measuringEquipmentNumber2 ?? '';
        $dailyreport->measuringEquipmentResult2 = $request->measuringEquipmentResult2 ?? '';
        $dailyreport->measuringEquipmentRemarks2 = $request->measuringEquipmentRemarks2 ?? '';

        // 連絡・報告事項等
        $dailyreport->patrolResult = $request->patrolResult ?? '';
        $dailyreport->patrolFindings = $request->patrolFindings ?? '';

        $dailyreport->save();

        return redirect('/');
    }

    public function index(){
        $dailyreports = Dailyreport::all();
        return view('top', ["dailyreports" => $dailyreports]);
    }
}
