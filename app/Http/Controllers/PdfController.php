<?php

namespace App\Http\Controllers;

use FPDI;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function getIndex()
    {
        $receipt = new FPDI();
        // PDFの余白(上左右)を設定
        $receipt->SetMargins(0, 0, 0);
        // ヘッダー・フッターの出力を無効化
        $receipt->setPrintHeader(false);
        $receipt->setPrintFooter(false);
        // ページを追加
        $receipt->AddPage();
        // テンプレートを読み込み
        $receipt->setSourceFile(public_path() . '/data/base.pdf');
        // 読み込んだPDFの1ページ目のインデックスを取得
        $tplIdx = $receipt->importPage(1);
        // 読み込んだPDFの1ページ目をテンプレートとして使用
        $receipt->useTemplate($tplIdx, null, null, null, null, true);

        // 書き込む文字列のフォントを指定
        $receipt->SetFont('', '', 20);
        // 書き込む位置
        $receipt->SetXY(13, 30);
        // 文字列を書き込む
        $receipt->Write(0, 'add string test!!');

        // PDFを出力
        $receipt->Output('sample.pdf', 'I');
    }
}
