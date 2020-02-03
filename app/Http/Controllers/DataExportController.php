<?php

namespace App\Http\Controllers;

use App\Dailyreport;
use App\Construction;
use Illuminate\Http\Request;

class DataExportController extends Controller
{
    public function index(){

        $constructions = Construction::all();
        return view('dataexport' , ["constructions" => $constructions]);
    }

    public function newdataexport(Request $request){
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $constructionNumber = $request->constructionNumber;
        $constructionName = str_replace(array("\r\n", "\r", "\n"), '', $request->constructionName);

        $dailyreports = Dailyreport::all();

        // 二日間の差を計算
        function day_diff($startDate, $endDate) {

            // 日付をUNIXタイムスタンプに変換
            $timestamp1 = strtotime($startDate);
            $timestamp2 = strtotime($endDate);

            // 何秒離れているかを計算
            $seconddiff = abs($timestamp2 - $timestamp1);

            // 日数に変換
            $daydiff = $seconddiff / (60 * 60 * 24);

            // 戻り値
            return $daydiff;

        }

        $dayDiff = day_diff($startDate, $endDate);

        // エクスポートするデータを格納する配列に日付の欄を作成
        $exportArrayData = array();
        foreach(range(0,$dayDiff) as $i){
            $addDate = '+' . $i . 'day';
            $exportArrayData[]['date'] = date("Y-m-d", strtotime($startDate . $addDate));
        }

        // 日報データを取り出し、エクスポートする配列に詰める
        foreach($exportArrayData as $key => $date){
            $reports = Dailyreport::where('constructionNumber', $constructionNumber)->where('date', $date)->get();
            $reports = $reports->sortByDesc('date');
            foreach($reports as $report){
                foreach (range(1,8) as $i){
                    $laborTraderName = "laborTraderName".$i;
                    $laborPeopleNumber = "laborPeopleNumber".$i;
                    $laborWorkTime = "laborWorkTime".$i;

                    $name = $report[$laborTraderName];

                    if( $exportArrayData[$key][$name] ?? false ){
                        // 追加処理
                        $exportArrayData[$key][$name] = $exportArrayData[$key][$name] + ( (int)$report[$laborPeopleNumber] * ( (int)$report[$laborWorkTime] / 8) ); // 人数 * ( 時間 / 8 ) NOTE:8は標準労働時間
                    } else if($report[$laborPeopleNumber] ?? false ) {
                        // 新規登録処理
                        $exportArrayData[$key][$name] = (int)$report[$laborPeopleNumber] * ( (int)$report[$laborWorkTime] / 8 ); // 人数 * ( 時間 / 8 ) NOTE:8は標準労働時間
                    }
                }

                foreach (range(1,6) as $i){
                    $heavyMachineryModel = "heavyMachineryModel".$i;
                    $heavyMachineryTime = "heavyMachineryTime".$i;

                    $name = $report[$heavyMachineryModel];

                    if( $exportArrayData[$key][$name] ?? false ){
                        // 追加処理
                        $exportArrayData[$key][$name] = $exportArrayData[$key][$name] + (int)$report[$heavyMachineryTime]; // 台数を表示
                    } else if($report[$heavyMachineryTime] ?? false ){
                        // 新規登録処理
                        $exportArrayData[$key][$name] = (int)$report[$heavyMachineryTime]; // 台数を表示
                    }
                }
            }
        }

        // 抽出項目
        $exportArrayItems = array();
        foreach($exportArrayData as $key => $exportData){
            $exportArrayItems = array_merge($exportArrayItems , array_keys($exportData));
        }
        // 重複削除
        $exportArrayItems = array_unique($exportArrayItems);
        // 空白削除
        $exportArrayItems = array_filter($exportArrayItems, "strlen");

        // csvデータ作成
        $csv = array();

        $csvitems = array();
        foreach($exportArrayItems as $item){
            $csvitems[] = $item;
        }
        $csv[] = $csvitems;

        foreach($exportArrayData as $exportData){
            $csvdata = array();
            foreach($exportArrayItems as $item){
                $csvdata[] = $exportData[$item] ?? 0;
            }
            $csv[] = $csvdata;
        }

        // csv出力
        $fileName = $constructionName . '労務・重機集計表';
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$fileName.csv");

        foreach ($csv as $line) fputcsv(fopen('php://output', 'w'), mb_convert_encoding($line, 'SJIS', 'UTF-8'));

    }
}
