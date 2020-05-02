<?php

namespace App\Http\Controllers;

use FPDI;
use Session;
use App\Construction;
use App\Dailyreport;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function createPdf(Request $request)
    {
        // データを取得できる
        $inputData = Dailyreport::find($request->reportid);
        if($inputData == null){
            return redirect('/');
        }

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
        $pdf->SetFont('kozgopromedium', '', 10);

        // 書き込むデータを格納
        $items = array();

        // 日付
        $weeknames = ['日','月','火','水','木','金','土'];
        $weekname = $weeknames[date( 'w', strtotime( $inputData['date'] ))];
        $items[] = array("x" => 26.0, "y" => 16.0, "content" => date( 'Y             m          d          ', strtotime( $inputData['date'] )) . $weekname );

        // 天気
        switch ($inputData['amWeather']){
            case "sun":
                $items[] = array("x" => 102.5, "y" => 14.0, "content" => "◯");
            break;
            case "cloud-sun":
                $items[] = array("x" => 111.5, "y" => 14.0, "content" => "◯");
            break;
            case "cloud":
                $items[] = array("x" => 120.5, "y" => 14.0, "content" => "◯");
            break;
            case "umbrella":
                $items[] = array("x" => 129.5, "y" => 14.0, "content" => "◯");
            break;
            case "snowflake":
                $items[] = array("x" => 138.0, "y" => 14.0, "content" => "◯");
            break;
        }
        switch ($inputData['pmWeather']){
            case "sun":
                $items[] = array("x" => 102.5, "y" => 18.5, "content" => "◯");
            break;
            case "cloud-sun":
                $items[] = array("x" => 111.5, "y" => 18.5, "content" => "◯");
            break;
            case "cloud":
                $items[] = array("x" => 120.5, "y" => 18.5, "content" => "◯");
            break;
            case "umbrella":
                $items[] = array("x" => 129.5, "y" => 18.5, "content" => "◯");
            break;
            case "snowflake":
                $items[] = array("x" => 138.0, "y" => 18.5, "content" => "◯");
            break;
        }

        // 工事番号
        $items[] = array("x" => 30.0, "y" => 25.0, "content" => $inputData['constructionNumber']);

        // 工事名
        $construction = explode("\n", $inputData['constructionName']);
        if(count($construction) == 1){
            $items[] = array("x" => 75.0, "y" => 25.0, "content" => $construction[0]);
        } else if (count($construction) == 2){
            $items[] = array("x" => 75.0, "y" => 22.5, "content" => $construction[0]);
            $items[] = array("x" => 75.0, "y" => 27.0, "content" => $construction[1]);
        }

        // 労務1
        $items[] = array("x" => 14.0, "y" => 39.0, "content" => $inputData['laborTraderName1']);
        $items[] = array("x" => 62.0, "y" => 39.0, "content" => $inputData['laborPeopleNumber1']);
        $items[] = array("x" => 77.0, "y" => 39.0, "content" => $inputData['laborWorkTime1']);
        if(mb_strlen($inputData['laborWorkVolume1'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 39.0, "content" => $inputData['laborWorkVolume1']);
        } else {
            $text = $inputData['laborWorkVolume1'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 37.5, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 41.0, "content" => $line2);
        }
        // 労務2
        $items[] = array("x" => 14.0, "y" => 46.5, "content" => $inputData['laborTraderName2']);
        $items[] = array("x" => 62.0, "y" => 46.5, "content" => $inputData['laborPeopleNumber2']);
        $items[] = array("x" => 77.0, "y" => 46.5, "content" => $inputData['laborWorkTime2']);
        if(mb_strlen($inputData['laborWorkVolume2'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 46.5, "content" => $inputData['laborWorkVolume2']);
        } else {
            $text = $inputData['laborWorkVolume2'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 45.0, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 48.5, "content" => $line2);
        }
        // 労務3
        $items[] = array("x" => 14.0, "y" => 54.0, "content" => $inputData['laborTraderName3']);
        $items[] = array("x" => 62.0, "y" => 54.0, "content" => $inputData['laborPeopleNumber3']);
        $items[] = array("x" => 77.0, "y" => 54.0, "content" => $inputData['laborWorkTime3']);
        if(mb_strlen($inputData['laborWorkVolume3'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 54.0, "content" => $inputData['laborWorkVolume3']);
        } else {
            $text = $inputData['laborWorkVolume3'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 52.5, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 56.0, "content" => $line2);
        }
        // 労務4
        $items[] = array("x" => 14.0, "y" => 61.5, "content" => $inputData['laborTraderName4']);
        $items[] = array("x" => 62.0, "y" => 61.5, "content" => $inputData['laborPeopleNumber4']);
        $items[] = array("x" => 77.0, "y" => 61.5, "content" => $inputData['laborWorkTime4']);
        if(mb_strlen($inputData['laborWorkVolume4'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 61.5, "content" => $inputData['laborWorkVolume4']);
        } else {
            $text = $inputData['laborWorkVolume4'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 60.0, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 63.5, "content" => $line2);
        }
        // 労務5
        $items[] = array("x" => 14.0, "y" => 69.0, "content" => $inputData['laborTraderName5']);
        $items[] = array("x" => 62.0, "y" => 69.0, "content" => $inputData['laborPeopleNumber5']);
        $items[] = array("x" => 77.0, "y" => 69.0, "content" => $inputData['laborWorkTime5']);
        if(mb_strlen($inputData['laborWorkVolume5'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 69.0, "content" => $inputData['laborWorkVolume5']);
        } else {
            $text = $inputData['laborWorkVolume5'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 67.5, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 71.0, "content" => $line2);
        }
        // 労務6
        $items[] = array("x" => 14.0, "y" => 76.5, "content" => $inputData['laborTraderName6']);
        $items[] = array("x" => 62.0, "y" => 76.5, "content" => $inputData['laborPeopleNumber6']);
        $items[] = array("x" => 77.0, "y" => 76.5, "content" => $inputData['laborWorkTime6']);
        if(mb_strlen($inputData['laborWorkVolume6'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 76.5, "content" => $inputData['laborWorkVolume6']);
        } else {
            $text = $inputData['laborWorkVolume6'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 75.0, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 78.5, "content" => $line2);
        }
        // 労務7
        $items[] = array("x" => 14.0, "y" => 84.0, "content" => $inputData['laborTraderName7']);
        $items[] = array("x" => 62.0, "y" => 84.0, "content" => $inputData['laborPeopleNumber7']);
        $items[] = array("x" => 77.0, "y" => 84.0, "content" => $inputData['laborWorkTime7']);
        if(mb_strlen($inputData['laborWorkVolume7'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 84.0, "content" => $inputData['laborWorkVolume7']);
        } else {
            $text = $inputData['laborWorkVolume7'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 83.0, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 86.5, "content" => $line2);
        }
        // 労務8
        $items[] = array("x" => 14.0, "y" => 91.5, "content" => $inputData['laborTraderName8']);
        $items[] = array("x" => 62.0, "y" => 91.5, "content" => $inputData['laborPeopleNumber8']);
        $items[] = array("x" => 77.0, "y" => 91.5, "content" => $inputData['laborWorkTime8']);
        if(mb_strlen($inputData['laborWorkVolume7'], 'UTF-8') < 25){
            $items[] = array("x" => 86.0, "y" => 91.5, "content" => $inputData['laborWorkVolume7']);
        } else {
            $text = $inputData['laborWorkVolume7'];
            $line1 = mb_substr( $text, 0, 25, 'UTF-8' );
            $line2 = mb_substr( $text, 25, 80, 'UTF-8' );
            $items[] = array("x" => 86.0, "y" => 90.5, "content" => $line1);
            $items[] = array("x" => 86.0, "y" => 94.0, "content" => $line2);
        }

        // 重機車両1
        $items[] = array("x" => 15.0, "y" => 105.0, "content" => $inputData['heavyMachineryTraderName1']);
        $items[] = array("x" => 45.0, "y" => 105.0, "content" => $inputData['heavyMachineryModel1']);
        $items[] = array("x" => 77.0, "y" => 105.0, "content" => $inputData['heavyMachineryTime1']);
        $items[] = array("x" => 86.0, "y" => 105.0, "content" => $inputData['heavyMachineryRemarks1']);
        // 重機車両2
        $items[] = array("x" => 15.0, "y" => 112.5, "content" => $inputData['heavyMachineryTraderName2']);
        $items[] = array("x" => 45.0, "y" => 112.5, "content" => $inputData['heavyMachineryModel2']);
        $items[] = array("x" => 77.0, "y" => 112.5, "content" => $inputData['heavyMachineryTime2']);
        $items[] = array("x" => 86.0, "y" => 112.5, "content" => $inputData['heavyMachineryRemarks2']);
        // 重機車両3
        $items[] = array("x" => 15.0, "y" => 120.0, "content" => $inputData['heavyMachineryTraderName3']);
        $items[] = array("x" => 45.0, "y" => 120.0, "content" => $inputData['heavyMachineryModel3']);
        $items[] = array("x" => 77.0, "y" => 120.0, "content" => $inputData['heavyMachineryTime3']);
        $items[] = array("x" => 86.0, "y" => 120.0, "content" => $inputData['heavyMachineryRemarks3']);
        // 重機車両4
        $items[] = array("x" => 104.0, "y" => 105.0, "content" => $inputData['heavyMachineryTraderName4']);
        $items[] = array("x" => 134.0, "y" => 105.0, "content" => $inputData['heavyMachineryModel4']);
        $items[] = array("x" => 166.0, "y" => 105.0, "content" => $inputData['heavyMachineryTime4']);
        $items[] = array("x" => 175.0, "y" => 105.0, "content" => $inputData['heavyMachineryRemarks4']);
        // 重機車両5
        $items[] = array("x" => 104.0, "y" => 112.5, "content" => $inputData['heavyMachineryTraderName5']);
        $items[] = array("x" => 134.0, "y" => 112.5, "content" => $inputData['heavyMachineryModel5']);
        $items[] = array("x" => 166.0, "y" => 112.5, "content" => $inputData['heavyMachineryTime5']);
        $items[] = array("x" => 175.0, "y" => 112.5, "content" => $inputData['heavyMachineryRemarks5']);
        // 重機車両6
        $items[] = array("x" => 104.0, "y" => 120.0, "content" => $inputData['heavyMachineryTraderName6']);
        $items[] = array("x" => 134.0, "y" => 120.0, "content" => $inputData['heavyMachineryModel6']);
        $items[] = array("x" => 166.0, "y" => 120.0, "content" => $inputData['heavyMachineryTime6']);
        $items[] = array("x" => 175.0, "y" => 120.0, "content" => $inputData['heavyMachineryRemarks6']);

        // 資材1
        $items[] = array("x" => 14.0, "y" => 137.0, "content" => $inputData['materialTraderName1']);
        $items[] = array("x" => 45.0, "y" => 137.0, "content" => $inputData['materialName1']);
        $items[] = array("x" => 75.0, "y" => 137.0, "content" => $inputData['materialShapeDimensions1']);
        $items[] = array("x" => 107.0, "y" => 137.0, "content" => $inputData['materialQuantity1']);
        $items[] = array("x" => 121.0, "y" => 137.0, "content" => $inputData['materialUnit1']);
        switch ($inputData['materialResult1']){
            case "pass":
                $items[] = array("x" => 132.0, "y" => 137.0, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 139.5, "y" => 137.0, "content" => "◯");
            break;
        }
        $items[] = array("x" => 146.0, "y" => 137.0, "content" => $inputData['materialInspectionMethods1']);
        $items[] = array("x" => 176.5, "y" => 137.0, "content" => $inputData['materialInspector1']);
        // 資材2
        $items[] = array("x" => 14.0, "y" => 144.5, "content" => $inputData['materialTraderName2']);
        $items[] = array("x" => 45.0, "y" => 144.5, "content" => $inputData['materialName2']);
        $items[] = array("x" => 75.0, "y" => 144.5, "content" => $inputData['materialShapeDimensions2']);
        $items[] = array("x" => 107.0, "y" => 144.5, "content" => $inputData['materialQuantity2']);
        $items[] = array("x" => 121.0, "y" => 144.5, "content" => $inputData['materialUnit2']);
        switch ($inputData['materialResult2']){
            case "pass":
                $items[] = array("x" => 132.0, "y" => 144.5, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 139.5, "y" => 144.5, "content" => "◯");
            break;
        }
        $items[] = array("x" => 146.0, "y" => 144.5, "content" => $inputData['materialInspectionMethods2']);
        $items[] = array("x" => 176.5, "y" => 144.5, "content" => $inputData['materialInspector2']);
        // 資材3
        $items[] = array("x" => 14.0, "y" => 152.0, "content" => $inputData['materialTraderName3']);
        $items[] = array("x" => 45.0, "y" => 152.0, "content" => $inputData['materialName3']);
        $items[] = array("x" => 75.0, "y" => 152.0, "content" => $inputData['materialShapeDimensions3']);
        $items[] = array("x" => 107.0, "y" => 152.0, "content" => $inputData['materialQuantity3']);
        $items[] = array("x" => 121.0, "y" => 152.0, "content" => $inputData['materialUnit3']);
        switch ($inputData['materialResult3']){
            case "pass":
                $items[] = array("x" => 132.0, "y" => 152.0, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 139.5, "y" => 152.0, "content" => "◯");
            break;
        }
        $items[] = array("x" => 146.0, "y" => 152.0, "content" => $inputData['materialInspectionMethods3']);
        $items[] = array("x" => 176.5, "y" => 152.0, "content" => $inputData['materialInspector3']);
        // 資材4
        $items[] = array("x" => 14.0, "y" => 159.5, "content" => $inputData['materialTraderName4']);
        $items[] = array("x" => 45.0, "y" => 159.5, "content" => $inputData['materialName4']);
        $items[] = array("x" => 75.0, "y" => 159.5, "content" => $inputData['materialShapeDimensions4']);
        $items[] = array("x" => 107.0, "y" => 159.5, "content" => $inputData['materialQuantity4']);
        $items[] = array("x" => 121.0, "y" => 159.5, "content" => $inputData['materialUnit4']);
        switch ($inputData['materialResult4']){
            case "pass":
                $items[] = array("x" => 132.0, "y" => 159.5, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 139.5, "y" => 159.5, "content" => "◯");
            break;
        }
        $items[] = array("x" => 146.0, "y" => 159.5, "content" => $inputData['materialInspectionMethods4']);
        $items[] = array("x" => 176.5, "y" => 159.5, "content" => $inputData['materialInspector4']);
        // 資材5
        $items[] = array("x" => 14.0, "y" => 167.0, "content" => $inputData['materialTraderName5']);
        $items[] = array("x" => 45.0, "y" => 167.0, "content" => $inputData['materialName5']);
        $items[] = array("x" => 75.0, "y" => 167.0, "content" => $inputData['materialShapeDimensions5']);
        $items[] = array("x" => 107.0, "y" => 167.0, "content" => $inputData['materialQuantity5']);
        $items[] = array("x" => 121.0, "y" => 167.0, "content" => $inputData['materialUnit5']);
        switch ($inputData['materialResult5']){
            case "pass":
                $items[] = array("x" => 132.0, "y" => 167.0, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 139.5, "y" => 167.0, "content" => "◯");
            break;
        }
        $items[] = array("x" => 146.0, "y" => 167.0, "content" => $inputData['materialInspectionMethods5']);
        $items[] = array("x" => 176.5, "y" => 167.0, "content" => $inputData['materialInspector5']);

        // 工程内検査1
        $items[] = array("x" => 14.0, "y" => 181.0, "content" => $inputData['processName1']);
        $items[] = array("x" => 55.0, "y" => 181.0, "content" => $inputData['processLocation1']);
        $items[] = array("x" => 96.0, "y" => 181.0, "content" => $inputData['processMethods1']);
        $items[] = array("x" => 131.0, "y" => 181.0, "content" => $inputData['processDocument1']);
        switch ($inputData['processResult1']){
            case "pass":
                $items[] = array("x" => 162.5, "y" => 181.0, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 170.5, "y" => 181.0, "content" => "◯");
            break;
        }
        $items[] = array("x" => 176.5, "y" => 181.0, "content" => $inputData['processInspector1']);
        // 工程内検査2
        $items[] = array("x" => 14.0, "y" => 188.5, "content" => $inputData['processName2']);
        $items[] = array("x" => 55.0, "y" => 188.5, "content" => $inputData['processLocation2']);
        $items[] = array("x" => 96.0, "y" => 188.5, "content" => $inputData['processMethods2']);
        $items[] = array("x" => 131.0, "y" => 188.5, "content" => $inputData['processDocument2']);
        switch ($inputData['processResult2']){
            case "pass":
                $items[] = array("x" => 162.5, "y" => 188.5, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 170.5, "y" => 188.5, "content" => "◯");
            break;
        }
        $items[] = array("x" => 176.5, "y" => 188.5, "content" => $inputData['processInspector2']);
        // 工程内検査3
        $items[] = array("x" => 14.0, "y" => 196.0, "content" => $inputData['processName3']);
        $items[] = array("x" => 55.0, "y" => 196.0, "content" => $inputData['processLocation3']);
        $items[] = array("x" => 96.0, "y" => 196.0, "content" => $inputData['processMethods3']);
        $items[] = array("x" => 131.0, "y" => 196.0, "content" => $inputData['processDocument3']);
        switch ($inputData['processResult3']){
            case "pass":
                $items[] = array("x" => 162.5, "y" => 196.0, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 170.5, "y" => 196.0, "content" => "◯");
            break;
        }
        $items[] = array("x" => 176.5, "y" => 196.0, "content" => $inputData['processInspector3']);
        // 工程内検査4
        $items[] = array("x" => 14.0, "y" => 203.5, "content" => $inputData['processName4']);
        $items[] = array("x" => 55.0, "y" => 203.5, "content" => $inputData['processLocation4']);
        $items[] = array("x" => 96.0, "y" => 203.5, "content" => $inputData['processMethods4']);
        $items[] = array("x" => 131.0, "y" => 203.5, "content" => $inputData['processDocument4']);
        switch ($inputData['processResult4']){
            case "pass":
                $items[] = array("x" => 162.5, "y" => 203.5, "content" => "◯");
            break;
            case "fail":
                $items[] = array("x" => 170.5, "y" => 203.5, "content" => "◯");
            break;
        }
        $items[] = array("x" => 176.5, "y" => 203.5, "content" => $inputData['processInspector4']);

        // 測定機器点検1
        $items[] = array("x" => 14.0, "y" => 217.0, "content" => $inputData['measuringEquipmentName1']);
        $items[] = array("x" => 45.0, "y" => 217.0, "content" => $inputData['measuringEquipmentNumber1']);
        switch ($inputData['measuringEquipmentResult1']){
            case "abnormal":
                $items[] = array("x" => 83.0, "y" => 217.0, "content" => "◯");
            break;
            case "noabnormal":
                $items[] = array("x" => 92.0, "y" => 217.0, "content" => "◯");
            break;
        }
        $items[] = array("x" => 106.0, "y" => 217.0, "content" => $inputData['measuringEquipmentRemarks1']);
        // 測定機器点検2
        $items[] = array("x" => 14.0, "y" => 224.5, "content" => $inputData['measuringEquipmentName2']);
        $items[] = array("x" => 45.0, "y" => 224.5, "content" => $inputData['measuringEquipmentNumber2']);
        switch ($inputData['measuringEquipmentResult2']){
            case "abnormal":
                $items[] = array("x" => 83.0, "y" => 224.5, "content" => "◯");
            break;
            case "noabnormal":
                $items[] = array("x" => 92.0, "y" => 224.5, "content" => "◯");
            break;
        }
        $items[] = array("x" => 106.0, "y" => 224.5, "content" => $inputData['measuringEquipmentRemarks2']);

        // 視察
        switch ($inputData['patrolResult']){
            case "abnormal":
                $items[] = array("x" => 69.0, "y" => 232.5, "content" => "◯");
            break;
            case "noabnormal":
                $items[] = array("x" => 81.0, "y" => 232.5, "content" => "◯");
            break;
        }

        // 連絡・報告事項等
        $patrolFindingsText = explode("\n", $inputData['patrolFindings']);
        foreach (range(1,count($patrolFindingsText)) as $i) {
            $y = 233.0 + 7.0 * $i;
            // 空白行でも表示できるように半角スペースを加算
            $items[] = array("x" => 14.0, "y" => $y, "content" => $patrolFindingsText[$i-1].' ');

            if ($i == 5) {
                break;
            }
        }

        // データを書き込み
        foreach ($items as $item){
            $pdf->SetXY($item["x"], $item["y"]);
            $pdf->Write(0, $item["content"]);
        }

        // PDFを出力
        $pdf->Output(date('Ymd', strtotime($inputData['date'])) . '-dailyreport.pdf', 'I');
    }

}
