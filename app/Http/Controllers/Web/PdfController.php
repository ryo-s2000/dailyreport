<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Dailyreport;
use App\Models\Trader;
use FPDI;

class PdfController extends Controller
{
    /**
     * @param mixed $reportId
     *
     * @return null|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function generate($reportId)
    {
        /*
         * WARNING
         * Ignore each() function error
         */
        error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

        // データを取得できる
        $inputData = Dailyreport::with(['construction'])->find($reportId);
        if (null === $inputData) {
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
        $pdf->setSourceFile(public_path().'/data/base.pdf');
        // 読み込んだPDFの1ページ目のインデックスを取得
        $tplIdx = $pdf->importPage(1);
        // 読み込んだPDFの1ページ目をテンプレートとして使用
        $pdf->useTemplate($tplIdx, null, 0, 0, 0, true);
        // 書き込む文字列のフォントを指定
        $pdf->SetFont('kozgopromedium', '', 10);

        // 書き込むデータを格納
        $items = [];

        // 日付
        $weeknames = ['日', '月', '火', '水', '木', '金', '土'];
        $weekInt = (int) date('w', strtotime($inputData['date']));
        $weekname = $weeknames[$weekInt];
        $items[] = ['x' => 26.0, 'y' => 16.0, 'content' => date('Y             m          d          ', strtotime($inputData['date'])).$weekname];

        // 天気
        switch ($inputData['amWeather']) {
            case 'sun':
                $items[] = ['x' => 102.5, 'y' => 14.0, 'content' => '◯'];

            break;

            case 'cloud-sun':
                $items[] = ['x' => 111.5, 'y' => 14.0, 'content' => '◯'];

            break;

            case 'cloud':
                $items[] = ['x' => 120.5, 'y' => 14.0, 'content' => '◯'];

            break;

            case 'umbrella':
                $items[] = ['x' => 129.5, 'y' => 14.0, 'content' => '◯'];

            break;

            case 'snowflake':
                $items[] = ['x' => 138.0, 'y' => 14.0, 'content' => '◯'];

            break;
        }

        switch ($inputData['pmWeather']) {
            case 'sun':
                $items[] = ['x' => 102.5, 'y' => 18.5, 'content' => '◯'];

            break;

            case 'cloud-sun':
                $items[] = ['x' => 111.5, 'y' => 18.5, 'content' => '◯'];

            break;

            case 'cloud':
                $items[] = ['x' => 120.5, 'y' => 18.5, 'content' => '◯'];

            break;

            case 'umbrella':
                $items[] = ['x' => 129.5, 'y' => 18.5, 'content' => '◯'];

            break;

            case 'snowflake':
                $items[] = ['x' => 138.0, 'y' => 18.5, 'content' => '◯'];

            break;
        }

        // 工事番号
        $items[] = ['x' => 30.0, 'y' => 25.0, 'content' => $inputData['construction']['number']];

        // 工事名
        $construction = explode("\n", $inputData['construction']['name']);
        if (1 === \count($construction)) {
            $items[] = ['x' => 75.0, 'y' => 25.0, 'content' => $construction[0]];
        } elseif (2 === \count($construction)) {
            $items[] = ['x' => 75.0, 'y' => 22.5, 'content' => $construction[0]];
            $items[] = ['x' => 75.0, 'y' => 27.0, 'content' => $construction[1]];
        }

        // 労務1
        $items[] = ['x' => 14.0, 'y' => 39.0, 'content' => self::trader_name($inputData['laborTraderId1'])];
        $items[] = ['x' => 62.0, 'y' => 39.0, 'content' => $inputData['laborPeopleNumber1']];
        $items[] = ['x' => 77.0, 'y' => 39.0, 'content' => $inputData['laborWorkTime1']];
        if (mb_strlen($inputData['laborWorkVolume1'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 39.0, 'content' => $inputData['laborWorkVolume1']];
        } else {
            $text = $inputData['laborWorkVolume1'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 37.5, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 41.0, 'content' => $line2];
        }
        // 労務2
        $items[] = ['x' => 14.0, 'y' => 46.5, 'content' => self::trader_name($inputData['laborTraderId2'])];
        $items[] = ['x' => 62.0, 'y' => 46.5, 'content' => $inputData['laborPeopleNumber2']];
        $items[] = ['x' => 77.0, 'y' => 46.5, 'content' => $inputData['laborWorkTime2']];
        if (mb_strlen($inputData['laborWorkVolume2'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 46.5, 'content' => $inputData['laborWorkVolume2']];
        } else {
            $text = $inputData['laborWorkVolume2'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 45.0, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 48.5, 'content' => $line2];
        }
        // 労務3
        $items[] = ['x' => 14.0, 'y' => 54.0, 'content' => self::trader_name($inputData['laborTraderId3'])];
        $items[] = ['x' => 62.0, 'y' => 54.0, 'content' => $inputData['laborPeopleNumber3']];
        $items[] = ['x' => 77.0, 'y' => 54.0, 'content' => $inputData['laborWorkTime3']];
        if (mb_strlen($inputData['laborWorkVolume3'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 54.0, 'content' => $inputData['laborWorkVolume3']];
        } else {
            $text = $inputData['laborWorkVolume3'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 52.5, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 56.0, 'content' => $line2];
        }
        // 労務4
        $items[] = ['x' => 14.0, 'y' => 61.5, 'content' => self::trader_name($inputData['laborTraderId4'])];
        $items[] = ['x' => 62.0, 'y' => 61.5, 'content' => $inputData['laborPeopleNumber4']];
        $items[] = ['x' => 77.0, 'y' => 61.5, 'content' => $inputData['laborWorkTime4']];
        if (mb_strlen($inputData['laborWorkVolume4'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 61.5, 'content' => $inputData['laborWorkVolume4']];
        } else {
            $text = $inputData['laborWorkVolume4'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 60.0, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 63.5, 'content' => $line2];
        }
        // 労務5
        $items[] = ['x' => 14.0, 'y' => 69.0, 'content' => self::trader_name($inputData['laborTraderId5'])];
        $items[] = ['x' => 62.0, 'y' => 69.0, 'content' => $inputData['laborPeopleNumber5']];
        $items[] = ['x' => 77.0, 'y' => 69.0, 'content' => $inputData['laborWorkTime5']];
        if (mb_strlen($inputData['laborWorkVolume5'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 69.0, 'content' => $inputData['laborWorkVolume5']];
        } else {
            $text = $inputData['laborWorkVolume5'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 67.5, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 71.0, 'content' => $line2];
        }
        // 労務6
        $items[] = ['x' => 14.0, 'y' => 76.5, 'content' => self::trader_name($inputData['laborTraderId6'])];
        $items[] = ['x' => 62.0, 'y' => 76.5, 'content' => $inputData['laborPeopleNumber6']];
        $items[] = ['x' => 77.0, 'y' => 76.5, 'content' => $inputData['laborWorkTime6']];
        if (mb_strlen($inputData['laborWorkVolume6'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 76.5, 'content' => $inputData['laborWorkVolume6']];
        } else {
            $text = $inputData['laborWorkVolume6'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 75.0, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 78.5, 'content' => $line2];
        }
        // 労務7
        $items[] = ['x' => 14.0, 'y' => 84.0, 'content' => self::trader_name($inputData['laborTraderId7'])];
        $items[] = ['x' => 62.0, 'y' => 84.0, 'content' => $inputData['laborPeopleNumber7']];
        $items[] = ['x' => 77.0, 'y' => 84.0, 'content' => $inputData['laborWorkTime7']];
        if (mb_strlen($inputData['laborWorkVolume7'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 84.0, 'content' => $inputData['laborWorkVolume7']];
        } else {
            $text = $inputData['laborWorkVolume7'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 83.0, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 86.5, 'content' => $line2];
        }
        // 労務8
        $items[] = ['x' => 14.0, 'y' => 91.5, 'content' => self::trader_name($inputData['laborTraderId8'])];
        $items[] = ['x' => 62.0, 'y' => 91.5, 'content' => $inputData['laborPeopleNumber8']];
        $items[] = ['x' => 77.0, 'y' => 91.5, 'content' => $inputData['laborWorkTime8']];
        if (mb_strlen($inputData['laborWorkVolume7'], 'UTF-8') < 25) {
            $items[] = ['x' => 86.0, 'y' => 91.5, 'content' => $inputData['laborWorkVolume7']];
        } else {
            $text = $inputData['laborWorkVolume7'];
            $line1 = mb_substr($text, 0, 25, 'UTF-8');
            $line2 = mb_substr($text, 25, 80, 'UTF-8');
            $items[] = ['x' => 86.0, 'y' => 90.5, 'content' => $line1];
            $items[] = ['x' => 86.0, 'y' => 94.0, 'content' => $line2];
        }

        // 重機車両1
        $items[] = ['x' => 15.0, 'y' => 105.0, 'content' => self::trader_name($inputData['heavyMachineryTraderId1'])];
        $items[] = ['x' => 45.0, 'y' => 105.0, 'content' => self::asset_name($inputData['heavyMachineryModel1'])];
        $items[] = ['x' => 77.0, 'y' => 105.0, 'content' => $inputData['heavyMachineryTime1']];
        $items[] = ['x' => 86.0, 'y' => 105.0, 'content' => $inputData['heavyMachineryRemarks1']];
        // 重機車両2
        $items[] = ['x' => 15.0, 'y' => 112.5, 'content' => self::trader_name($inputData['heavyMachineryTraderId2'])];
        $items[] = ['x' => 45.0, 'y' => 112.5, 'content' => self::asset_name($inputData['heavyMachineryModel2'])];
        $items[] = ['x' => 77.0, 'y' => 112.5, 'content' => $inputData['heavyMachineryTime2']];
        $items[] = ['x' => 86.0, 'y' => 112.5, 'content' => $inputData['heavyMachineryRemarks2']];
        // 重機車両3
        $items[] = ['x' => 15.0, 'y' => 120.0, 'content' => self::trader_name($inputData['heavyMachineryTraderId3'])];
        $items[] = ['x' => 45.0, 'y' => 120.0, 'content' => self::asset_name($inputData['heavyMachineryModel3'])];
        $items[] = ['x' => 77.0, 'y' => 120.0, 'content' => $inputData['heavyMachineryTime3']];
        $items[] = ['x' => 86.0, 'y' => 120.0, 'content' => $inputData['heavyMachineryRemarks3']];
        // 重機車両4
        $items[] = ['x' => 104.0, 'y' => 105.0, 'content' => self::trader_name($inputData['heavyMachineryTraderId4'])];
        $items[] = ['x' => 134.0, 'y' => 105.0, 'content' => self::asset_name($inputData['heavyMachineryModel4'])];
        $items[] = ['x' => 166.0, 'y' => 105.0, 'content' => $inputData['heavyMachineryTime4']];
        $items[] = ['x' => 175.0, 'y' => 105.0, 'content' => $inputData['heavyMachineryRemarks4']];
        // 重機車両5
        $items[] = ['x' => 104.0, 'y' => 112.5, 'content' => self::trader_name($inputData['heavyMachineryTraderId5'])];
        $items[] = ['x' => 134.0, 'y' => 112.5, 'content' => self::asset_name($inputData['heavyMachineryModel5'])];
        $items[] = ['x' => 166.0, 'y' => 112.5, 'content' => $inputData['heavyMachineryTime5']];
        $items[] = ['x' => 175.0, 'y' => 112.5, 'content' => $inputData['heavyMachineryRemarks5']];
        // 重機車両6
        $items[] = ['x' => 104.0, 'y' => 120.0, 'content' => self::trader_name($inputData['heavyMachineryTraderId6'])];
        $items[] = ['x' => 134.0, 'y' => 120.0, 'content' => self::asset_name($inputData['heavyMachineryModel6'])];
        $items[] = ['x' => 166.0, 'y' => 120.0, 'content' => $inputData['heavyMachineryTime6']];
        $items[] = ['x' => 175.0, 'y' => 120.0, 'content' => $inputData['heavyMachineryRemarks6']];

        // 資材1
        $items[] = ['x' => 14.0, 'y' => 137.0, 'content' => $inputData['materialTraderName1']];
        $items[] = ['x' => 45.0, 'y' => 137.0, 'content' => $inputData['materialName1']];
        $items[] = ['x' => 75.0, 'y' => 137.0, 'content' => $inputData['materialShapeDimensions1']];
        $items[] = ['x' => 107.0, 'y' => 137.0, 'content' => $inputData['materialQuantity1']];
        $items[] = ['x' => 121.0, 'y' => 137.0, 'content' => $inputData['materialUnit1']];

        switch ($inputData['materialResult1']) {
            case 'pass':
                $items[] = ['x' => 132.0, 'y' => 137.0, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 139.5, 'y' => 137.0, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 146.0, 'y' => 137.0, 'content' => $inputData['materialInspectionMethods1']];
        $items[] = ['x' => 176.5, 'y' => 137.0, 'content' => $inputData['materialInspector1']];
        // 資材2
        $items[] = ['x' => 14.0, 'y' => 144.5, 'content' => $inputData['materialTraderName2']];
        $items[] = ['x' => 45.0, 'y' => 144.5, 'content' => $inputData['materialName2']];
        $items[] = ['x' => 75.0, 'y' => 144.5, 'content' => $inputData['materialShapeDimensions2']];
        $items[] = ['x' => 107.0, 'y' => 144.5, 'content' => $inputData['materialQuantity2']];
        $items[] = ['x' => 121.0, 'y' => 144.5, 'content' => $inputData['materialUnit2']];

        switch ($inputData['materialResult2']) {
            case 'pass':
                $items[] = ['x' => 132.0, 'y' => 144.5, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 139.5, 'y' => 144.5, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 146.0, 'y' => 144.5, 'content' => $inputData['materialInspectionMethods2']];
        $items[] = ['x' => 176.5, 'y' => 144.5, 'content' => $inputData['materialInspector2']];
        // 資材3
        $items[] = ['x' => 14.0, 'y' => 152.0, 'content' => $inputData['materialTraderName3']];
        $items[] = ['x' => 45.0, 'y' => 152.0, 'content' => $inputData['materialName3']];
        $items[] = ['x' => 75.0, 'y' => 152.0, 'content' => $inputData['materialShapeDimensions3']];
        $items[] = ['x' => 107.0, 'y' => 152.0, 'content' => $inputData['materialQuantity3']];
        $items[] = ['x' => 121.0, 'y' => 152.0, 'content' => $inputData['materialUnit3']];

        switch ($inputData['materialResult3']) {
            case 'pass':
                $items[] = ['x' => 132.0, 'y' => 152.0, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 139.5, 'y' => 152.0, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 146.0, 'y' => 152.0, 'content' => $inputData['materialInspectionMethods3']];
        $items[] = ['x' => 176.5, 'y' => 152.0, 'content' => $inputData['materialInspector3']];
        // 資材4
        $items[] = ['x' => 14.0, 'y' => 159.5, 'content' => $inputData['materialTraderName4']];
        $items[] = ['x' => 45.0, 'y' => 159.5, 'content' => $inputData['materialName4']];
        $items[] = ['x' => 75.0, 'y' => 159.5, 'content' => $inputData['materialShapeDimensions4']];
        $items[] = ['x' => 107.0, 'y' => 159.5, 'content' => $inputData['materialQuantity4']];
        $items[] = ['x' => 121.0, 'y' => 159.5, 'content' => $inputData['materialUnit4']];

        switch ($inputData['materialResult4']) {
            case 'pass':
                $items[] = ['x' => 132.0, 'y' => 159.5, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 139.5, 'y' => 159.5, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 146.0, 'y' => 159.5, 'content' => $inputData['materialInspectionMethods4']];
        $items[] = ['x' => 176.5, 'y' => 159.5, 'content' => $inputData['materialInspector4']];
        // 資材5
        $items[] = ['x' => 14.0, 'y' => 167.0, 'content' => $inputData['materialTraderName5']];
        $items[] = ['x' => 45.0, 'y' => 167.0, 'content' => $inputData['materialName5']];
        $items[] = ['x' => 75.0, 'y' => 167.0, 'content' => $inputData['materialShapeDimensions5']];
        $items[] = ['x' => 107.0, 'y' => 167.0, 'content' => $inputData['materialQuantity5']];
        $items[] = ['x' => 121.0, 'y' => 167.0, 'content' => $inputData['materialUnit5']];

        switch ($inputData['materialResult5']) {
            case 'pass':
                $items[] = ['x' => 132.0, 'y' => 167.0, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 139.5, 'y' => 167.0, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 146.0, 'y' => 167.0, 'content' => $inputData['materialInspectionMethods5']];
        $items[] = ['x' => 176.5, 'y' => 167.0, 'content' => $inputData['materialInspector5']];

        // 工程内検査1
        $items[] = ['x' => 14.0, 'y' => 181.0, 'content' => $inputData['processName1']];
        $items[] = ['x' => 55.0, 'y' => 181.0, 'content' => $inputData['processLocation1']];
        $items[] = ['x' => 96.0, 'y' => 181.0, 'content' => $inputData['processMethods1']];
        $items[] = ['x' => 131.0, 'y' => 181.0, 'content' => $inputData['processDocument1']];

        switch ($inputData['processResult1']) {
            case 'pass':
                $items[] = ['x' => 162.5, 'y' => 181.0, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 170.5, 'y' => 181.0, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 176.5, 'y' => 181.0, 'content' => $inputData['processInspector1']];
        // 工程内検査2
        $items[] = ['x' => 14.0, 'y' => 188.5, 'content' => $inputData['processName2']];
        $items[] = ['x' => 55.0, 'y' => 188.5, 'content' => $inputData['processLocation2']];
        $items[] = ['x' => 96.0, 'y' => 188.5, 'content' => $inputData['processMethods2']];
        $items[] = ['x' => 131.0, 'y' => 188.5, 'content' => $inputData['processDocument2']];

        switch ($inputData['processResult2']) {
            case 'pass':
                $items[] = ['x' => 162.5, 'y' => 188.5, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 170.5, 'y' => 188.5, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 176.5, 'y' => 188.5, 'content' => $inputData['processInspector2']];
        // 工程内検査3
        $items[] = ['x' => 14.0, 'y' => 196.0, 'content' => $inputData['processName3']];
        $items[] = ['x' => 55.0, 'y' => 196.0, 'content' => $inputData['processLocation3']];
        $items[] = ['x' => 96.0, 'y' => 196.0, 'content' => $inputData['processMethods3']];
        $items[] = ['x' => 131.0, 'y' => 196.0, 'content' => $inputData['processDocument3']];

        switch ($inputData['processResult3']) {
            case 'pass':
                $items[] = ['x' => 162.5, 'y' => 196.0, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 170.5, 'y' => 196.0, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 176.5, 'y' => 196.0, 'content' => $inputData['processInspector3']];
        // 工程内検査4
        $items[] = ['x' => 14.0, 'y' => 203.5, 'content' => $inputData['processName4']];
        $items[] = ['x' => 55.0, 'y' => 203.5, 'content' => $inputData['processLocation4']];
        $items[] = ['x' => 96.0, 'y' => 203.5, 'content' => $inputData['processMethods4']];
        $items[] = ['x' => 131.0, 'y' => 203.5, 'content' => $inputData['processDocument4']];

        switch ($inputData['processResult4']) {
            case 'pass':
                $items[] = ['x' => 162.5, 'y' => 203.5, 'content' => '◯'];

            break;

            case 'fail':
                $items[] = ['x' => 170.5, 'y' => 203.5, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 176.5, 'y' => 203.5, 'content' => $inputData['processInspector4']];

        // 測定機器点検1
        $items[] = ['x' => 14.0, 'y' => 217.0, 'content' => $inputData['measuringEquipmentName1']];
        $items[] = ['x' => 45.0, 'y' => 217.0, 'content' => $inputData['measuringEquipmentNumber1']];

        switch ($inputData['measuringEquipmentResult1']) {
            case 'abnormal':
                $items[] = ['x' => 83.0, 'y' => 217.0, 'content' => '◯'];

            break;

            case 'noabnormal':
                $items[] = ['x' => 92.0, 'y' => 217.0, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 106.0, 'y' => 217.0, 'content' => $inputData['measuringEquipmentRemarks1']];
        // 測定機器点検2
        $items[] = ['x' => 14.0, 'y' => 224.5, 'content' => $inputData['measuringEquipmentName2']];
        $items[] = ['x' => 45.0, 'y' => 224.5, 'content' => $inputData['measuringEquipmentNumber2']];

        switch ($inputData['measuringEquipmentResult2']) {
            case 'abnormal':
                $items[] = ['x' => 83.0, 'y' => 224.5, 'content' => '◯'];

            break;

            case 'noabnormal':
                $items[] = ['x' => 92.0, 'y' => 224.5, 'content' => '◯'];

            break;
        }
        $items[] = ['x' => 106.0, 'y' => 224.5, 'content' => $inputData['measuringEquipmentRemarks2']];

        // 視察
        switch ($inputData['patrolResult']) {
            case 'abnormal':
                $items[] = ['x' => 69.0, 'y' => 232.5, 'content' => '◯'];

            break;

            case 'noabnormal':
                $items[] = ['x' => 81.0, 'y' => 232.5, 'content' => '◯'];

            break;
        }

        // 連絡・報告事項等
        $patrolFindingsText = explode("\n", $inputData['patrolFindings']);
        foreach (range(1, \count($patrolFindingsText)) as $i) {
            $y = 233.0 + 7.0 * $i;
            // 空白行でも表示できるように半角スペースを加算
            $items[] = ['x' => 14.0, 'y' => $y, 'content' => $patrolFindingsText[$i - 1].' '];

            if (5 === $i) {
                break;
            }
        }

        // データを書き込み
        foreach ($items as $item) {
            $pdf->SetXY($item['x'], $item['y']);
            $pdf->Write(0, $item['content']);
        }

        // PDFを出力
        $pdf->Output(date('Ymd', strtotime($inputData['date'])).'-dailyreport.pdf', 'I');
    }

    private function trader_name($id)
    {
        $trader = Trader::where('id', $id)->first();

        if (null === $trader) {
            return '';
        }

        return $trader->name;
    }

    private function asset_name($id)
    {
        $asset = Asset::where('id', $id)->first();

        if (null === $asset) {
            return '';
        }

        return $asset->name;
    }
}
