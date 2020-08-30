<?php

namespace App\Http\Controllers\Api;

use App\Dailyreport;
use App\Asset;
use App\Trader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // postされたデータを取得
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $constructionNumber = $request->constructionNumber;

        // 工事番号と日付を指定して、日報データを取得
        $reports = self::getReport($constructionNumber, $startDate, $endDate);

        // 従業員・重機のデータを取得、整形、ユニーク
        list($uniqueLaborTraderIds, $uniqueHeavyMachineryModels) = self::getUniqueLaborAndHeavyMachineData($reports);

        $returnLaborTraderIds = array();
        $returnHeavyMachineryModels = array();
        foreach ($uniqueLaborTraderIds as $id) {
            $data = array(
                'laborTraderId' => $id,
                'laborTraderName' => self::searchLaborTraderName($id)
            );

            array_push(
                $returnLaborTraderIds, $data
            );
        }
        foreach ($uniqueHeavyMachineryModels as $id) {
            $data = array(
                'heavyMachineryModel' => $id,
                'heavyMachineName' => self::searchHeavyMachineName($id),
                'heavyMachineTraderName' => self::searchLaborTraderName($id)
            );

            array_push(
                $returnHeavyMachineryModels, $data
            );
        }

        $return_data = array(
            'laborTraderIds' => $returnLaborTraderIds,
            'heavyMachineryModels' => $returnHeavyMachineryModels
        );

        return response()->json($return_data);
    }

    public function export(Request $request)
    {
        // postされたデータを取得
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $laborTraderUnitPrice = $request->laborTraderUnitPrice;
        $heavyMachineUnitPrice = $request->heavyMachineUnitPrice;
        $constructionNumber = $request->constructionNumber;
        $constructionName = str_replace(array("\r\n", "\r", "\n"), '', $request->constructionName);

        // 工事番号と日付を指定して、日報データを取得
        $reports = self::getReport($constructionNumber, $startDate, $endDate);

        /////////////// CSVのCOLUMN情報を取得する ///////////////
        // 従業員・重機のデータを取得、整形、ユニーク
        list($uniqueLaborTraderIds, $uniqueHeavyMachineryModels) = self::getUniqueLaborAndHeavyMachineData($reports);
        $laborTraderColumnCount = count($uniqueLaborTraderIds);
        $heavyMachineryModelColumnCount = count($uniqueHeavyMachineryModels);
        $lowCount = $laborTraderColumnCount+$heavyMachineryModelColumnCount;

        /////////////// CSVのROW情報を取得する ///////////////
        // エクスポートするデータの日付を取得(ROWS)
        $exportPeriod = self::getExportPeriod($startDate, $endDate);

        /////////////// CSVにデータをつめる ///////////////
        $csv = self::fillCsvData($reports, $exportPeriod, $lowCount, $uniqueLaborTraderIds, $uniqueHeavyMachineryModels, $laborTraderColumnCount);

        // rowを定義
        $rows = $exportPeriod;

        // 累計
        array_push($rows, '累計');
        $cumulative = self::aggregateCumulative($csv);
        array_push($csv, $cumulative);

        // 単価(燃料共)
        array_push($rows, '単価(燃料共)');
        $unitpriceRow = self::aggregateUnitpriceRow($laborTraderUnitPrice, $uniqueLaborTraderIds, $heavyMachineUnitPrice, $uniqueHeavyMachineryModels, $laborTraderColumnCount, $lowCount);
        array_push($csv, $unitpriceRow);

        // 計
        array_push($rows, '計');
        $subtotalRow = self::aggregateSubtotalRow($cumulative, $unitpriceRow, $lowCount);
        array_push($csv, $subtotalRow);

        // 合計
        array_push($rows, '合計');
        $total = array_fill(0, $lowCount, '');
        $total[count($total)-1] = array_sum($subtotalRow);
        array_push($csv, $total);

        /////////////// CSV出力 ///////////////
        // ファイル名
        $fileName =  '【' . $constructionNumber . '】' . $constructionName . '労務・重機集計表.csv';

        // column
        $columnTopFrame = array_fill(0, $lowCount, '');
        $columnTop = self::conversionColumnTop($columnTopFrame, $uniqueLaborTraderIds);
        $column = self::conversionColumn($uniqueLaborTraderIds, $uniqueHeavyMachineryModels);
        array_unshift($csv, $column);
        array_unshift($csv, $columnTop);

        // row
        array_unshift($rows, '');
        array_unshift($rows, '');
        foreach($rows as $i => $row) {
            array_unshift($csv[$i], $row);
        }

        $returnData = array(
            'fileName' => $fileName,
            'csv' => $csv
        );

        return response()->json($returnData);
    }

    private function getReport($constructionNumber, $startDate, $endDate) {
        $query = Dailyreport::query();
        $query->where('constructionNumber', $constructionNumber);
        $query->whereBetween('date', [$startDate, $endDate]);
        $reports = $query->get();

        return $reports;
    }

    private function searchLaborTraderName($id) {
        $trader = Trader::where('id', $id)->first();
        return $trader->name;
    }

    private function searchHeavyMachineName($id) {
        $asset = Asset::where('id', $id)->first();
        return $asset->name;
    }

    private function getUniqueLaborAndHeavyMachineData($reports) {
        $laborTraderIds = array();
        $heavyMachineryModels = array();

        foreach ($reports as $report) {
            foreach (range(1,8) as $i) {
                $laborTraderId = "laborTraderId".$i;
                if($report->$laborTraderId) {
                    array_push(
                        $laborTraderIds, $report->$laborTraderId
                    );
                }
            }
            foreach (range(1,6) as $i){
                $heavyMachineryModel = "heavyMachineryModel".$i;
                if($report->$heavyMachineryModel) {
                    array_push(
                        $heavyMachineryModels, $report->$heavyMachineryModel
                    );
                }
            }
        }

        // 重複を削除
        $uniqueLaborTraderIds = array_unique($laborTraderIds);
        $uniqueHeavyMachineryModels = array_unique($heavyMachineryModels);

        //キーが飛び飛びになっているので、キーを振り直す
        $uniqueLaborTraderIds = array_values($uniqueLaborTraderIds);
        $uniqueHeavyMachineryModels = array_values($uniqueHeavyMachineryModels);

        return [$uniqueLaborTraderIds, $uniqueHeavyMachineryModels];
    }

    private function getExportPeriod($startDate, $endDate) {
        function day_diff($startDate, $endDate) {

            // 日付をUNIXタイムスタンプに変換
            $timestamp1 = strtotime($startDate);
            $timestamp2 = strtotime($endDate);

            // 何秒離れているかを計算
            $seconddiff = abs($timestamp2 - $timestamp1);

            // 日数に変換
            $daydiff = $seconddiff / (60 * 60 * 24);

            return $daydiff;
        }
        $dayDiff = day_diff($startDate, $endDate);

        // エクスポートするデータの日付を取得(ROWS)
        $exportPeriod = array();
        foreach(range(0,$dayDiff) as $i){
            $addDate = '+' . $i . 'day';
            array_push(
                $exportPeriod, date("Y-m-d", strtotime($startDate . $addDate))
            );
        }

        return $exportPeriod;
    }

    private function fillCsvData($reports, $exportPeriod, $lowCount, $uniqueLaborTraderIds, $uniqueHeavyMachineryModels, $laborTraderColumnCount) {
        $csv = array();

        // 指定した日付の日報を取得する
        function filterPeriodDateReport($reports, $date) {
            return array_filter($reports->toArray(), function($report) use ($date) {
                return $report['date'] == $date . ' 00:00:00';
            });
        }
        // 1行ごとに集計していく
        foreach($exportPeriod as $date) {
            $filterdReports = filterPeriodDateReport($reports, $date);

            if(!empty($filterdReports)) {
                $row = array_fill(0, $lowCount, 0);

                foreach($filterdReports as $report) {
                    foreach ($uniqueLaborTraderIds as $index => $id) {
                        foreach (range(1,8) as $i) {
                            $laborTraderId = "laborTraderId".$i;
                            if($report[$laborTraderId] == $id) {
                                $row[$index]++;
                            }
                        }
                    }

                    foreach ($uniqueHeavyMachineryModels as $index => $id) {
                        foreach (range(1,6) as $i) {
                            $heavyMachineryModel = "heavyMachineryModel".$i;
                            if($report[$heavyMachineryModel] == $id) {
                                $row[$index+$laborTraderColumnCount]++;
                            }
                        }
                    }
                }

                array_push($csv, $row);
            } else {
                array_push($csv, array_fill(0, $lowCount, 0));
            }
        }

        return $csv;
    }

    private function aggregateCumulative($csv) {
        $cumulative = array_fill(0, count($csv[0]), 0);
        foreach($csv as $row) {
            foreach($row as $i => $count) {
                $cumulative[$i] += $count;
            }
        }

        return $cumulative;
    }

    private function aggregateUnitpriceRow($laborTraderUnitPrice, $uniqueLaborTraderIds, $heavyMachineUnitPrice, $uniqueHeavyMachineryModels, $laborTraderColumnCount, $lowCount) {
        $unitpriceRow = array_fill(0, $lowCount, 0);
        if(!empty($laborTraderUnitPrice)) {
            foreach($laborTraderUnitPrice as $unitPrice) {
                foreach ($uniqueLaborTraderIds as $index => $id) {
                    if($unitPrice['id'] == $id) {
                        $unitpriceRow[$index] = (int)$unitPrice['price'];
                    }
                }
            }
        }
        if(!empty($heavyMachineUnitPrice)) {
            foreach($heavyMachineUnitPrice as $unitPrice) {
                foreach ($uniqueHeavyMachineryModels as $index => $id) {
                    if($unitPrice['id'] == $id) {
                        $unitpriceRow[$index+$laborTraderColumnCount] = (int)$unitPrice['price'];
                    }
                }
            }
        }

        return $unitpriceRow;
    }

    private function aggregateSubtotalRow($cumulative, $unitpriceRow, $lowCount) {
        $subtotalRow = array_fill(0, $lowCount, 0);
        foreach($subtotalRow as $i => $v) {
            $subtotalRow[$i] = $cumulative[$i] * $unitpriceRow[$i];
        }

        return $subtotalRow;
    }

    private function conversionColumnTop($columnTop, $traderIds) {
        $columnTop[0] = '労務';
        $columnTop[count($traderIds)] = '重機';

        return $columnTop;
    }

    private function conversionColumn($traderIds, $heavyMachineryModels) {
        $traderColumn = array();
        $heavyMachineColumn = array();

        foreach ($traderIds as $id) {
            array_push(
                $traderColumn, 'オペ・作業員' . '【' . self::searchLaborTraderName($id) . '】'
            );
        }
        foreach ($heavyMachineryModels as $id) {
            array_push(
                $heavyMachineColumn, self::searchHeavyMachineName($id) . '【' . self::searchLaborTraderName($id) . '】'
            );
        }

        return array_merge($traderColumn, $heavyMachineColumn);
    }
}
