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
        $dailyreport->username = $request->username ?? '';
        $dailyreport->date = $request->date ?? '';
        $dailyreport->amweather = $request->amweather ?? '';
        $dailyreport->pmweather = $request->pmweather ?? '';
        $dailyreport->constructionNumber = $request->constructionNumber ?? '';
        $dailyreport->constructionName = $request->constructionName ?? '';
        $dailyreport->traderName1 = $request->traderName1 ?? '';
        $dailyreport->peopleNumber1 = $request->peopleNumber1 ?? '';
        $dailyreport->workingTime1 = $request->workingTime1 ?? '';
        $dailyreport->work1 = $request->work1 ?? '';
        $dailyreport->traderName2 = $request->traderName2 ?? '';
        $dailyreport->peopleNumber2 = $request->peopleNumber2 ?? '';
        $dailyreport->workingTime2 = $request->workingTime2 ?? '';
        $dailyreport->work2 = $request->work2 ?? '';
        $dailyreport->traderName3 = $request->traderName3 ?? '';
        $dailyreport->peopleNumber3 = $request->peopleNumber3 ?? '';
        $dailyreport->workingTime3 = $request->workingTime3 ?? '';
        $dailyreport->work3 = $request->work3 ?? '';
        $dailyreport->traderName4 = $request->traderName4 ?? '';
        $dailyreport->peopleNumber4 = $request->peopleNumber4 ?? '';
        $dailyreport->workingTime4 = $request->workingTime4 ?? '';
        $dailyreport->work4 = $request->work4 ?? '';
        $dailyreport->traderName5 = $request->traderName5 ?? '';
        $dailyreport->peopleNumber5 = $request->peopleNumber5 ?? '';
        $dailyreport->workingTime5 = $request->workingTime5 ?? '';
        $dailyreport->work5 = $request->work5 ?? '';
        $dailyreport->materialTraderName1 = $request->materialTraderName1 ?? '';
        $dailyreport->materialName1 = $request->materialName1 ?? '';
        $dailyreport->shapeDimensions1 = $request->shapeDimensions1 ?? '';
        $dailyreport->quantity1 = $request->quantity1 ?? '';
        $dailyreport->unit1 = $request->unit1 ?? '';
        $dailyreport->materialTraderName2 = $request->materialTraderName2 ?? '';
        $dailyreport->materialName2 = $request->materialName2 ?? '';
        $dailyreport->shapeDimensions2 = $request->shapeDimensions2 ?? '';
        $dailyreport->quantity2 = $request->quantity2 ?? '';
        $dailyreport->unit2 = $request->unit2 ?? '';
        $dailyreport->materialTraderName3 = $request->materialTraderName3 ?? '';
        $dailyreport->materialName3 = $request->materialName3 ?? '';
        $dailyreport->shapeDimensions3 = $request->shapeDimensions3 ?? '';
        $dailyreport->quantity3 = $request->quantity3 ?? '';
        $dailyreport->unit3 = $request->unit3 ?? '';
        $dailyreport->materialTraderName4 = $request->materialTraderName4 ?? '';
        $dailyreport->materialName4 = $request->materialName4 ?? '';
        $dailyreport->shapeDimensions4 = $request->shapeDimensions4 ?? '';
        $dailyreport->quantity4 = $request->quantity4 ?? '';
        $dailyreport->unit4 = $request->unit4 ?? '';
        $dailyreport->materialTraderName5 = $request->materialTraderName5 ?? '';
        $dailyreport->materialName5 = $request->materialName5 ?? '';
        $dailyreport->shapeDimensions5 = $request->shapeDimensions5 ?? '';
        $dailyreport->quantity5 = $request->quantity5 ?? '';
        $dailyreport->unit5 = $request->unit5 ?? '';

        $dailyreport->save();

        return redirect('/');
    }

    public function index(){
        $dailyreports = Dailyreport::all();
        return view('top', ["dailyreports" => $dailyreports]);
    }
}
