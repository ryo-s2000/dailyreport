<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dailyreport;
use App\Models\Trader;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class VenderDataExportController extends Controller
{
    public function generate(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $traderId = $request->traderId;

        return response()->json(
            [
                'fileName' => $this->generateFileName($startDate, $endDate, $traderId),
                'content' => $this->generateCsv($startDate, $endDate, $traderId),
            ]
        );
    }

    private function generateFileName(string $startDate, string $endDate, int $traderId): string
    {
        $traderName = Trader::find($traderId)->name;

        return implode('_', ['業者名別レポート', $startDate, $endDate, $traderName]).'.csv';
    }

    private function generateCsv(string $startDate, string $endDate, int $traderId): array
    {
        function generateColumns(string $startDate, string $endDate): array
        {
            $columns = ['', ''];

            $period = CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $columns[] = $date->format('m/d');
            }

            return $columns;
        }

        function gemerateRows(string $startDate, string $endDate, int $traderId, array $columns): array
        {
            $rows = [];

            // WARNING
            // Low performance
            $reports = collect();
            for ($i = 1; $i <= 8; ++$i) {
                $reports = $reports->merge(
                    Dailyreport::select('constructions.number as constructionNumber', 'constructions.name as constructionName', 'laborPeopleNumber'.$i.' as count', 'laborWorkTime'.$i.' as time', 'date')
                        ->join('constructions', 'dailyreports.construction_id', '=', 'constructions.id')
                        ->where('laborTraderId'.$i, $traderId)
                        ->whereBetween('date', [$startDate, $endDate])
                        ->get()
                        ->all()
                );
            }

            $constructions = $reports->unique('constructionNumber')->pluck('constructionName', 'constructionNumber')->all();
            foreach ($constructions as $constructionNumber => $constructionName) {
                $row = [$constructionNumber, $constructionName];

                foreach ($columns as $date) {
                    if (empty($date)) {
                        continue;
                    }

                    $value = 0;

                    // WARNING
                    // Don't work correctly over 1 year
                    $filteredReports = $reports->filter(function ($report) use ($constructionNumber, $date) {
                        return $report->constructionNumber === $constructionNumber && (new Carbon($report->date))->format('m/d') === $date;
                    });
                    foreach ($filteredReports as $report) {
                        if (is_numeric($report->time) && is_numeric($report->count)) {
                            $value += ($report->time * $report->count) / 8.0;
                        }
                    }

                    $row[] = $value;
                }

                $rows[] = $row;
            }

            return $rows;
        }

        function gemerateTotal(array $rows, int $columnCount): array
        {
            $totals = ['', '小計'];

            $rowCount = \count($rows);

            for ($l = 2; $l < $columnCount; ++$l) {
                $total = 0;

                for ($r = 0; $r < $rowCount; ++$r) {
                    $total += $rows[$r][$l];
                }

                $totals[] = $total;
            }

            return $totals;
        }

        $columns = generateColumns($startDate, $endDate);
        $columnCount = \count($columns);
        $rows = gemerateRows($startDate, $endDate, $traderId, $columns);
        $total = gemerateTotal($rows, $columnCount);
        $margin = array_fill(0, $columnCount, '');

        $csv = $rows;
        array_unshift($csv, $columns);
        $csv[] = $margin;
        $csv[] = $total;

        return $csv;
    }
}
