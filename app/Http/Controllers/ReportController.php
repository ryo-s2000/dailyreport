<?php

namespace App\Http\Controllers;

use Image;
use Storage;
use App\Dailyreport;
use App\Construction;
use App\Trader;
use App\Asset;
use App\Signature;
use Illuminate\Http\Request;
use App\Http\Requests\DailyreportRequest;

class ReportController extends Controller
{
    public function newReport(){
        $dailyreport = new Dailyreport;
        $dailyreport->date = date("Y-m-d");
        $constructions = Construction::all();
        $traders = array(
            array('id'=>'', 'name'=>'部署を選択してください')
        );
        $assets = array();
        for ($i = 1; $i <= 6; $i++) {
            array_push(
                $assets, array(array('id'=>'', 'name'=>'業者名を選択してください'))
            );
        }
        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions, "traders" => $traders, "assets" => $assets]);
    }

    public function editReport(Request $request){
        $dailyreport = Dailyreport::find($request->report_id);
        if($dailyreport == null){
            return redirect('/');
        }
        $constructions = Construction::all();

        $return_traders = array(
            array('id'=>'', 'name'=>'業者名を選択してください')
        );
        $traders = Trader::where('department_id', $dailyreport->department_id)->get();
        foreach ($traders as $trader) {
            array_push(
                $return_traders, array('id'=>$trader->id, 'name'=>$trader->name)
            );
        }

        $return_assets = array();
        for ($i = 1; $i <= 6; $i++) {
            $individual_assets = array(
                array('id'=>'', 'name'=>'業者名を選択してください')
            );

            $heavyMachineryTraderId = "heavyMachineryTraderId".$i;
            $trader_id = $dailyreport->$heavyMachineryTraderId;
            $assets = Asset::where('trader_id', $trader_id)->get();
            foreach ($assets as $asset) {
                array_push(
                    $individual_assets, array('id'=>$asset->id, 'name'=>$asset->name)
                );
            }

            array_push(
                $return_assets, $individual_assets
            );
        }

        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions, "traders" => $return_traders, "assets" => $return_assets]);
    }

    public function saveEditReport(DailyreportRequest $request, $report_id){
        $dailyreport = Dailyreport::find($report_id);
        if($dailyreport == null){
            return redirect('/');
        }

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // 遷移先を変更する。
        $transitionPreview = $form['transition-preview'];
        unset($form['transition-preview']);

        // データを詰め込む
        $dailyreport->fill($form)->save();
        $dailyreportId = $dailyreport->id;

        $redirectPath = '/';
        if($transitionPreview == 'true'){
            $redirectPath = '/pdf/' . $dailyreportId;
        }

        return redirect($redirectPath);
    }

    public function saveReport(DailyreportRequest $request){
        $dailyreport = new Dailyreport;

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // 遷移先を変更する。
        $transitionPreview = $form['transition-preview'];
        unset($form['transition-preview']);

        // データを詰め込む
        $dailyreport->fill($form)->save();
        $dailyreportId = $dailyreport->id;

        $redirectPath = '/';
        if($transitionPreview == 'true'){
            $redirectPath = '/pdf/' . $dailyreportId;
        }

        return redirect($redirectPath);
    }

    public function copyReport(Request $request){
        $dailyreport = Dailyreport::find($request->report_id);
        $dailyreport->date = date("Y-m-d");

        if($dailyreport == null){
            return redirect('/');
        }
        $constructions = Construction::all();
        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions]);
    }

    public function deleteReport(Dailyreport $report_id){
        if( !(Dailyreport::find($report_id)) ){
            return redirect('/');
        }

        $report_id->delete();

        return redirect('/');
    }

    public function showReport(Request $request){
        $dailyreport = Dailyreport::find($request->report_id);
        if($dailyreport == null){
            return redirect('/');
        }
        return view('showreport', ['dailyreport' => $dailyreport]);
    }

    public function index(Request $request){
        function condition($value = null){
            if($value){
                return '=';
            } else {
                return 'LIKE';
            }
        }

        function value($value = null){
            if($value){
                return $value;
            } else {
                return '%';
            }
        }

        $dailyreports = Dailyreport::where('userName', condition($request->userName), value($request->userName))
            ->where('department_id', condition($request->department_id), value($request->department_id))
            ->where('constructionNumber', condition($request->constructionNumber), value($request->constructionNumber));
        switch ($request->sort){
            case '日付が早い順':
                $dailyreports = $dailyreports->orderBy('date')->paginate(100);
                break;
            case '日付が遅い順':
                $dailyreports = $dailyreports->orderByDesc('date')->paginate(100);
                break;
            default:
                $dailyreports = $dailyreports->orderByDesc('date')->paginate(100);
        }

        $dailyreportsPalams = array(
            'userName' => $request->userName,
            'department_id' => $request->department_id,
            'constructionNumber' => $request->constructionNumber,
            'constructionName' => $request->constructionName,
            'sort' => $request->sort,
        );

        $allDailyreports = Dailyreport::all();
        $constructions = Construction::all();
        return view('top', ["dailyreports" => $dailyreports, "dailyreportsPalams" => $dailyreportsPalams, "allDailyreports" => $allDailyreports, "constructions" => $constructions]);
    }
}
