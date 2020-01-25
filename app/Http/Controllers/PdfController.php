<?php

namespace App\Http\Controllers;

use FPDI;
use Session;
use App\Construction;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function createPdf()
    {
        // データを取得できる
        $inputData = Session::get('_old_input');

        $pdf = new FPDI();
        // PDFの余白(上左右)を設定
        $pdf->SetMargins(0, 0, 0);
        // ヘッダー・フッターの出力を無効化
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        // ページを追加
        $pdf->AddPage();
        // テンプレートを読み込み
        $pdf->setSourceFile(public_path() . '/data/base.pdf');
        // 読み込んだPDFの1ページ目のインデックスを取得
        $tplIdx = $pdf->importPage(1);
        // 読み込んだPDFの1ページ目をテンプレートとして使用
        $pdf->useTemplate($tplIdx, null, null, null, null, true);
        // 書き込む文字列のフォントを指定
        $pdf->SetFont('kozminproregular', '', 15);

        // 書き込むデータを格納
        $items = array();
        // 日付
        $weeknames = ['日','月','火','水','木','金','土'];
        $weekname = $weeknames[date( 'w', strtotime( $inputData['date'] ))];
        $items[] = array("x" => 24.0,  "y" => 15.0, "content" => date( 'Y   m    d    ', strtotime( $inputData['date'] )) . $weekname );
        // 天気
        switch ($inputData['amweather']){
            case "sunny":
                $items[] = array("x" => 101.5,  "y" => 13.0, "content" => "◯");
            break;
            case "sunnyandcloudy":
                $items[] = array("x" => 110.5,  "y" => 13.0, "content" => "◯");
            break;
            case "cloudy":
                $items[] = array("x" => 119.5,  "y" => 13.0, "content" => "◯");
            break;
            case "rain":
                $items[] = array("x" => 128.5,  "y" => 13.0, "content" => "◯");
            break;
            case "snow":
                $items[] = array("x" => 137.5,  "y" => 13.0, "content" => "◯");
            break;
        }
        switch ($inputData['pmweather']){
            case "sunny":
                $items[] = array("x" => 101.5,  "y" => 17.5, "content" => "◯");
            break;
            case "sunnyandcloudy":
                $items[] = array("x" => 110.5,  "y" => 17.5, "content" => "◯");
            break;
            case "cloudy":
                $items[] = array("x" => 119.5,  "y" => 17.5, "content" => "◯");
            break;
            case "rain":
                $items[] = array("x" => 128.5,  "y" => 17.5, "content" => "◯");
            break;
            case "snow":
                $items[] = array("x" => 137.5,  "y" => 17.5, "content" => "◯");
            break;
        }
        // 工事番号
        $items[] = array("x" => 30.0,  "y" => 24.0, "content" => $inputData['constructionNumber']);
        // 工事名
        $construction = Construction::where('number', $inputData['constructionNumber'])->get();
        if(count($construction) != 0){
            // 行数によって処理を切り替える
            $constructionName = explode("\n", $construction[0]->name);
            if(count($constructionName) == 1){
                $items[] = array("x" => 75.0,  "y" => 24.0, "content" => $constructionName[0]);
            } else if (count($constructionName) == 2){
                $items[] = array("x" => 75.0,  "y" => 21.5, "content" => $constructionName[0]);
                $items[] = array("x" => 75.0,  "y" => 26.0, "content" => $constructionName[1]);
            }else{
                // 何も表示しない
            }
        }
        // 労務A
        $items[] = array("x" => 15.0,  "y" => 38.0, "content" => $inputData['traderName1']);
        $items[] = array("x" => 61.0,  "y" => 38.0, "content" => $inputData['peopleNumber1']);
        $items[] = array("x" => 77.0,  "y" => 38.0, "content" => $inputData['workingTime1']);
        $items[] = array("x" => 86.0,  "y" => 38.0, "content" => $inputData['work1']);
        // 労務B
        $items[] = array("x" => 15.0,  "y" => 45.5, "content" => $inputData['traderName2']);
        $items[] = array("x" => 61.0,  "y" => 45.5, "content" => $inputData['peopleNumber2']);
        $items[] = array("x" => 77.0,  "y" => 45.5, "content" => $inputData['workingTime2']);
        $items[] = array("x" => 86.0,  "y" => 45.5, "content" => $inputData['work2']);
        // 労務C
        $items[] = array("x" => 15.0,  "y" => 53.0, "content" => $inputData['traderName3']);
        $items[] = array("x" => 61.0,  "y" => 53.0, "content" => $inputData['peopleNumber3']);
        $items[] = array("x" => 77.0,  "y" => 53.0, "content" => $inputData['workingTime3']);
        $items[] = array("x" => 86.0,  "y" => 53.0, "content" => $inputData['work3']);
        // 労務D
        $items[] = array("x" => 15.0,  "y" => 60.5, "content" => $inputData['traderName4']);
        $items[] = array("x" => 61.0,  "y" => 60.5, "content" => $inputData['peopleNumber4']);
        $items[] = array("x" => 77.0,  "y" => 60.5, "content" => $inputData['workingTime4']);
        $items[] = array("x" => 86.0,  "y" => 60.5, "content" => $inputData['work4']);
        // 労務E
        $items[] = array("x" => 15.0,  "y" => 68.0, "content" => $inputData['traderName5']);
        $items[] = array("x" => 61.0,  "y" => 68.0, "content" => $inputData['peopleNumber5']);
        $items[] = array("x" => 77.0,  "y" => 68.0, "content" => $inputData['workingTime5']);
        $items[] = array("x" => 86.0,  "y" => 68.0, "content" => $inputData['work5']);
        // 資材A
        $items[] = array("x" => 15.0,  "y" => 136.0, "content" => $inputData['materialTraderName1']);
        $items[] = array("x" => 46.0,  "y" => 136.0, "content" => $inputData['materialName1']);
        $items[] = array("x" => 76.0,  "y" => 136.0, "content" => $inputData['shapeDimensions1']);
        $items[] = array("x" => 107.0,  "y" => 136.0, "content" => $inputData['quantity1']);
        $items[] = array("x" => 121.0,  "y" => 136.0, "content" => $inputData['unit1']);
        // 資材B
        $items[] = array("x" => 15.0,  "y" => 143.5, "content" => $inputData['materialTraderName2']);
        $items[] = array("x" => 46.0,  "y" => 143.5, "content" => $inputData['materialName2']);
        $items[] = array("x" => 76.0,  "y" => 143.5, "content" => $inputData['shapeDimensions2']);
        $items[] = array("x" => 107.0,  "y" => 143.5, "content" => $inputData['quantity2']);
        $items[] = array("x" => 121.0,  "y" => 143.5, "content" => $inputData['unit2']);
        // 資材C
        $items[] = array("x" => 15.0,  "y" => 151.0, "content" => $inputData['materialTraderName3']);
        $items[] = array("x" => 46.0,  "y" => 151.0, "content" => $inputData['materialName3']);
        $items[] = array("x" => 76.0,  "y" => 151.0, "content" => $inputData['shapeDimensions3']);
        $items[] = array("x" => 107.0,  "y" => 151.0, "content" => $inputData['quantity3']);
        $items[] = array("x" => 121.0,  "y" => 151.0, "content" => $inputData['unit3']);
        // 資材D
        $items[] = array("x" => 15.0,  "y" => 158.5, "content" => $inputData['materialTraderName4']);
        $items[] = array("x" => 46.0,  "y" => 158.5, "content" => $inputData['materialName4']);
        $items[] = array("x" => 76.0,  "y" => 158.5, "content" => $inputData['shapeDimensions4']);
        $items[] = array("x" => 107.0,  "y" => 158.5, "content" => $inputData['quantity4']);
        $items[] = array("x" => 121.0,  "y" => 158.5, "content" => $inputData['unit4']);
        // 資材E
        $items[] = array("x" => 15.0,  "y" => 166.0, "content" => $inputData['materialTraderName5']);
        $items[] = array("x" => 46.0,  "y" => 166.0, "content" => $inputData['materialName5']);
        $items[] = array("x" => 76.0,  "y" => 166.0, "content" => $inputData['shapeDimensions5']);
        $items[] = array("x" => 107.0,  "y" => 166.0, "content" => $inputData['quantity5']);
        $items[] = array("x" => 121.0,  "y" => 166.0, "content" => $inputData['unit5']);
        // 視察
        $items[] = array("x" => 80.5,  "y" => 231.5, "content" => "◯");

        // データを書き込み
        foreach ($items as $item){
            $pdf->SetXY($item["x"], $item["y"]);
            $pdf->Write(0, $item["content"]);
        }

        // PDFを出力
        $pdf->Output(date('Ymd', strtotime($inputData['date'])) . '-dailyreport.pdf', 'I');
    }

    public function savePdf(Request $request){
        return redirect('/pdf')->withInput();

    }
}
