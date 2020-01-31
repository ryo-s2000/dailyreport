<?php

namespace App\Http\Controllers;

use Storage;
use App\Dailyreport;
use App\Construction;
use Illuminate\Http\Request;
use App\Http\Requests\DailyreportRequest;

class ReportController extends Controller
{
    public function newReport(){
        $dailyreport = new Dailyreport;
        $dailyreport->date = date("Y-m-d");
        $constructions = Construction::all();
        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions]);
    }

    public function editReport(Request $request){
        $dailyreport = Dailyreport::find($request->reportid);
        if($dailyreport == null){
            return redirect('/');
        }
        $constructions = Construction::all();
        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions]);
    }

    public function saveEditReport(DailyreportRequest $request, $reportid){
        $dailyreport = Dailyreport::find($reportid);
        if($dailyreport == null){
            return redirect('/');
        }

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // 画像保存処理
        foreach (range(1,5) as $i){
            $name = 'imagepath' . $i;
            $file = $request->file($name);
            if($file == null){
                $dailyreport->$name = "";
            } else {
                $fileName = $file->getClientOriginalExtension();
                if($fileName == "jpg" or $fileName == "jpeg" or $fileName == "png"){
                    $path = Storage::disk('s3')->putFile('/', $file, 'public');
                    $dailyreport->$name = Storage::disk('s3')->url($path);
                }
            }
        }

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // データを詰め込む
        $dailyreport->fill($form)->save();

        return redirect('/');
    }

    public function saveReport(DailyreportRequest $request){
        $dailyreport = new Dailyreport;

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // 画像保存処理
        foreach (range(1,5) as $i){
            $name = 'imagepath' . $i;
            $file = $request->file($name);
            if($file == null){
                $dailyreport->$name = "";
            } else {
                $fileName = $file->getClientOriginalExtension();
                if($fileName == "jpg" or $fileName == "jpeg" or $fileName == "png"){
                    $path = Storage::disk('s3')->putFile('/', $file, 'public');
                    $dailyreport->$name = Storage::disk('s3')->url($path);
                }
            }
        }

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // データを詰め込む
        $dailyreport->fill($form)->save();

        return redirect('/');
    }

    public function deleteReport(Dailyreport $reportid){
        if( !(Dailyreport::find($reportid)) ){
            return redirect('/');
        }

        $reportid->delete();

        return redirect('/');
    }

    public function index(){
        $dailyreports = Dailyreport::all();
        return view('top', ["dailyreports" => $dailyreports]);
    }
}
