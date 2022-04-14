<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Dailyreport;
use App\Models\Trader;
use Illuminate\Http\Request;

class VenderDataExportController extends Controller
{
    public function generate(Request $request)
    {
        // postされたデータを取得
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $laborTraderUnitPrice = $request->laborTraderUnitPrice;
        $heavyMachineUnitPrice = $request->heavyMachineUnitPrice;
        $constructionNumber = $request->constructionNumber;
        $constructionName = str_replace(["\r\n", "\r", "\n"], '', $request->constructionName);
        $constructionId = $request->constructionId;

        // 工事番号と日付を指定して、日報データを取得
        $reports = self::getReport($constructionId, $startDate, $endDate);

        /////////////// CSVのCOLUMN情報を取得する ///////////////
        // 従業員・重機のデータを取得、整形、ユニーク
        [$uniqueLaborTraderIds, $uniqueHeavyMachineryModels] = self::getUniqueLaborAndHeavyMachineData($reports);
        $laborTraderColumnCount = \count($uniqueLaborTraderIds);
        $heavyMachineryModelColumnCount = \count($uniqueHeavyMachineryModels);
        $lowCount = $laborTraderColumnCount + $heavyMachineryModelColumnCount;

        /////////////// CSVのROW情報を取得する ///////////////
        // エクスポートするデータの日付を取得(ROWS)
        $exportPeriod = self::getExportPeriod($startDate, $endDate);

        /////////////// CSVにデータをつめる ///////////////
        $csv = self::fillCsvData($reports, $exportPeriod, $lowCount, $uniqueLaborTraderIds, $uniqueHeavyMachineryModels, $laborTraderColumnCount);

        // rowを定義
        $rows = $exportPeriod;

        // 累計
        $rows[] = '累計';
        $cumulative = self::aggregateCumulative($csv);
        $csv[] = $cumulative;

        // 単価(燃料共)
        $rows[] = '単価(燃料共)';
        $unitpriceRow = self::aggregateUnitpriceRow($laborTraderUnitPrice, $uniqueLaborTraderIds, $heavyMachineUnitPrice, $uniqueHeavyMachineryModels, $laborTraderColumnCount, $lowCount);
        $csv[] = $unitpriceRow;

        // 計
        $rows[] = '計';
        $subtotalRow = self::aggregateSubtotalRow($cumulative, $unitpriceRow, $lowCount);
        $csv[] = $subtotalRow;

        // 合計
        $rows[] = '合計';
        $total = array_fill(0, $lowCount, '');
        $total[\count($total) - 1] = array_sum($subtotalRow);
        $csv[] = $total;

        /////////////// CSV出力 ///////////////
        // ファイル名
        $fileName = '【'.$constructionNumber.'】'.$constructionName.'労務・重機集計表.csv';

        // column
        $columnTopFrame = array_fill(0, $lowCount, '');
        $columnTop = self::conversionColumnTop($columnTopFrame, $uniqueLaborTraderIds);
        $column = self::conversionColumn($uniqueLaborTraderIds, $uniqueHeavyMachineryModels);
        array_unshift($csv, $column);
        array_unshift($csv, $columnTop);

        // row
        array_unshift($rows, '');
        array_unshift($rows, '');
        foreach ($rows as $i => $row) {
            array_unshift($csv[$i], $row);
        }

        $returnData = [
            'fileName' => $fileName,
            'content' => $csv,
        ];

        return response()->json($returnData);
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Collection|array<\Illuminate\Database\Eloquent\Builder>
     *
     * @param mixed $constructionId
     * @param mixed $startDate
     * @param mixed $endDate
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getReport($constructionId, $startDate, $endDate)
    {
        $query = Dailyreport::query();
        $query->where('construction_id', $constructionId);
        $query->whereBetween('date', [$startDate, $endDate]);

        return $query->get();
    }

    private function searchLaborTraderName($id)
    {
        $trader = Trader::where('id', $id)->first();

        return $trader->name;
    }

    private function searchHeavyMachineName($id)
    {
        $asset = Asset::where('id', $id)->first();

        return $asset->name;
    }

    private function searchHeavyMachineTraderName($id)
    {
        $asset = Asset::where('id', $id)->first();

        return self::searchLaborTraderName($asset->trader_id);
    }

    /**
     * @psalm-return array{0: list<mixed>, 1: list<mixed>}
     *
     * @param mixed $reports
     *
     * @return array[]
     */
    private function getUniqueLaborAndHeavyMachineData($reports): array
    {
        $laborTraderIds = [];
        $heavyMachineryModels = [];

        foreach ($reports as $report) {
            foreach (range(1, 8) as $i) {
                $laborTraderId = 'laborTraderId'.$i;
                if ($report->{$laborTraderId}) {
                    $laborTraderIds[] =
                        $report->{$laborTraderId}
                    ;
                }
            }
            foreach (range(1, 6) as $i) {
                $heavyMachineryModel = 'heavyMachineryModel'.$i;
                if ($report->{$heavyMachineryModel}) {
                    $heavyMachineryModels[] =
                        $report->{$heavyMachineryModel}
                    ;
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

    /**
     * @psalm-return non-empty-list<string>
     *
     * @param mixed $startDate
     * @param mixed $endDate
     *
     * @return string[]
     */
    private function getExportPeriod($startDate, $endDate): array
    {
        /**
         * @param mixed $startDate
         * @param mixed $endDate
         *
         * @return float|int
         */
        function day_diff($startDate, $endDate)
        {
            // 日付をUNIXタイムスタンプに変換
            $timestamp1 = strtotime($startDate);
            $timestamp2 = strtotime($endDate);

            // 何秒離れているかを計算
            $seconddiff = abs($timestamp2 - $timestamp1);

            // 日数に変換
            return $seconddiff / (60 * 60 * 24);
        }
        $dayDiff = day_diff($startDate, $endDate);

        // エクスポートするデータの日付を取得(ROWS)
        $exportPeriod = [];
        foreach (range(0, $dayDiff) as $i) {
            $addDate = '+'.$i.'day';

            $exportPeriod[] =
                date('Y-m-d', strtotime($startDate.$addDate))
            ;
        }

        return $exportPeriod;
    }

    /**
     * @psalm-return list<array<float|int>>
     *
     * @param mixed $reports
     * @param mixed $exportPeriod
     * @param mixed $uniqueLaborTraderIds
     * @param mixed $uniqueHeavyMachineryModels
     *
     * @return (float|int)[][]
     */
    private function fillCsvData($reports, $exportPeriod, int $lowCount, $uniqueLaborTraderIds, $uniqueHeavyMachineryModels, int $laborTraderColumnCount): array
    {
        $csv = [];

        // 指定した日付の日報を取得する
        function filterPeriodDateReport($reports, $date): array
        {
            return array_filter($reports->toArray(), function ($report) use ($date) {
                return $report['date'] === $date.' 00:00:00';
            });
        }
        // 1行ごとに集計していく
        foreach ($exportPeriod as $date) {
            $filterdReports = filterPeriodDateReport($reports, $date);

            if (!empty($filterdReports)) {
                $row = array_fill(0, $lowCount, 0);

                foreach ($filterdReports as $report) {
                    foreach ($uniqueLaborTraderIds as $index => $id) {
                        foreach (range(1, 8) as $i) {
                            $laborTraderId = 'laborTraderId'.$i;
                            $laborPeopleNumber = 'laborPeopleNumber'.$i;
                            $laborWorkTime = 'laborWorkTime'.$i;

                            if ($report[$laborTraderId] === $id) {
                                // 小数点2位で切り捨て
                                // (人数*時間)/8時間
                                $row[$index] += round((((int) $report[$laborPeopleNumber] * (int) $report[$laborWorkTime]) / 8), 2);
                            }
                        }
                    }

                    foreach ($uniqueHeavyMachineryModels as $index => $id) {
                        foreach (range(1, 6) as $i) {
                            $heavyMachineryModel = 'heavyMachineryModel'.$i;
                            $heavyMachineryTime = 'heavyMachineryTime'.$i;

                            if ($report[$heavyMachineryModel] === $id) {
                                $row[$index + $laborTraderColumnCount] += (int) $report[$heavyMachineryTime];
                            }
                        }
                    }
                }

                $csv[] = $row;
            } else {
                $csv[] = array_fill(0, $lowCount, 0);
            }
        }

        return $csv;
    }

    /**
     * @psalm-return list<0|mixed>
     *
     * @param mixed $csv
     *
     * @return (int|mixed)[]
     */
    private function aggregateCumulative($csv): array
    {
        $cumulative = array_fill(0, \count($csv[0]), 0);
        foreach ($csv as $row) {
            foreach ($row as $i => $count) {
                $cumulative[$i] += $count;
            }
        }

        return $cumulative;
    }

    /**
     * @psalm-return array<int>
     *
     * @param mixed $laborTraderUnitPrice
     * @param mixed $uniqueLaborTraderIds
     * @param mixed $heavyMachineUnitPrice
     * @param mixed $uniqueHeavyMachineryModels
     *
     * @return int[]
     */
    private function aggregateUnitpriceRow($laborTraderUnitPrice, $uniqueLaborTraderIds, $heavyMachineUnitPrice, $uniqueHeavyMachineryModels, int $laborTraderColumnCount, int $lowCount): array
    {
        $unitpriceRow = array_fill(0, $lowCount, 0);
        if (!empty($laborTraderUnitPrice)) {
            foreach ($laborTraderUnitPrice as $unitPrice) {
                foreach ($uniqueLaborTraderIds as $index => $id) {
                    if ($unitPrice['id'] === $id) {
                        $unitpriceRow[$index] = (int) $unitPrice['price'];
                    }
                }
            }
        }
        if (!empty($heavyMachineUnitPrice)) {
            foreach ($heavyMachineUnitPrice as $unitPrice) {
                foreach ($uniqueHeavyMachineryModels as $index => $id) {
                    if ($unitPrice['id'] === $id) {
                        $unitpriceRow[$index + $laborTraderColumnCount] = (int) $unitPrice['price'];
                    }
                }
            }
        }

        return $unitpriceRow;
    }

    /**
     * @psalm-return list<0|mixed>
     *
     * @param mixed $cumulative
     * @param mixed $unitpriceRow
     *
     * @return (int|mixed)[]
     */
    private function aggregateSubtotalRow($cumulative, $unitpriceRow, int $lowCount): array
    {
        $subtotalRow = array_fill(0, $lowCount, 0);
        foreach ($subtotalRow as $i => $v) {
            $subtotalRow[$i] = $cumulative[$i] * $unitpriceRow[$i];
        }

        return $subtotalRow;
    }

    /**
     * @param string[] $columnTop
     * @param mixed    $traderIds
     *
     * @psalm-param list<''> $columnTop
     *
     * @return string[]
     *
     * @psalm-return array<int, ''|'労務'|'重機'>
     */
    private function conversionColumnTop(array $columnTop, $traderIds): array
    {
        $columnTop[0] = '労務';
        $columnTop[\count($traderIds)] = '重機';

        return $columnTop;
    }

    /**
     * @psalm-return list<string>
     *
     * @param mixed $traderIds
     * @param mixed $heavyMachineryModels
     *
     * @return string[]
     */
    private function conversionColumn($traderIds, $heavyMachineryModels): array
    {
        $traderColumn = [];
        $heavyMachineColumn = [];

        foreach ($traderIds as $id) {
            $traderColumn[] =
                'オペ・作業員'.'【'.self::searchLaborTraderName($id).'】'
            ;
        }
        foreach ($heavyMachineryModels as $id) {
            $heavyMachineColumn[] =
                self::searchHeavyMachineName($id).'【'.self::searchHeavyMachineTraderName($id).'】'
            ;
        }

        return array_merge($traderColumn, $heavyMachineColumn);
    }
}
