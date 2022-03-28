<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DailyreportRequest;
use App\Models\Asset;
use App\Models\Construction;
use App\Models\Dailyreport;
use App\Models\Trader;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        function condition($value = null)
        {
            if ($value) {
                return '=';
            }

            return 'LIKE';
        }

        function value($value = null)
        {
            if ($value) {
                return $value;
            }

            return '%';
        }

        $dailyreports = Dailyreport::where('userName', condition($request->userName), value($request->userName))
            ->where('department_id', condition($request->department_id), value($request->department_id))
            ->where('constructionNumber', condition($request->constructionNumber), value($request->constructionNumber))
        ;

        switch ($request->sort) {
            case '日付が早い順':
                $dailyreports = $dailyreports->orderBy('date')->paginate(100);

                break;

            case '日付が遅い順':
                $dailyreports = $dailyreports->orderByDesc('date')->paginate(100);

                break;

            default:
                $dailyreports = $dailyreports->orderByDesc('date')->paginate(100);
        }

        $dailyreportsPalams = [
            'userName' => $request->userName,
            'department_id' => $request->department_id,
            'constructionNumber' => $request->constructionNumber,
            'constructionName' => $request->constructionName,
            'sort' => $request->sort,
        ];

        // TODO send userNames
        $allDailyreports = Dailyreport::all();
        $constructions = Construction::all();

        return view('report.top', ['dailyreports' => $dailyreports, 'dailyreportsPalams' => $dailyreportsPalams, 'allDailyreports' => $allDailyreports, 'constructions' => $constructions]);
    }

    public function create()
    {
        $dailyreport = new Dailyreport();
        $dailyreport->date = date('Y-m-d');
        $constructions = Construction::all();
        $traders = [
            ['id' => '', 'name' => '部署を選択してください'],
        ];
        $assets = [];
        for ($i = 1; $i <= 6; ++$i) {
            $assets[] =
                [['id' => '', 'name' => '業者名を選択してください']]
            ;
        }

        return view('report.create_and_edit', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets]);
    }

    public function store(DailyreportRequest $request)
    {
        $dailyreport = new Dailyreport();

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item) {
            if (null === $item) {
                $form[$key] = '';
            }
        }

        // 遷移先を変更する。
        $transitionPreview = $form['transition-preview'];
        unset($form['transition-preview']);

        // データを詰め込む
        $dailyreport->fill($form)->save();
        $dailyreportId = $dailyreport->id;

        $redirectPath = '/';
        if ('true' === $transitionPreview) {
            $redirectPath = '/pdf/'.$dailyreportId;
        }

        return redirect($redirectPath);
    }

    public function show(Request $request)
    {
        $dailyreport = Dailyreport::find($request->report_id);
        if (null === $dailyreport) {
            return redirect('/');
        }

        return view('report.show', ['dailyreport' => $dailyreport]);
    }

    public function edit(Request $request)
    {
        $dailyreport = Dailyreport::find($request->report_id);

        if (null === $dailyreport) {
            return redirect('/');
        }

        $constructions = Construction::all();

        $traders = self::fillTraders($dailyreport);

        $assets = self::fillAssets($dailyreport);

        return view('report.create_and_edit', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets]);
    }

    public function saveEditReport(DailyreportRequest $request, $report_id)
    {
        $dailyreport = Dailyreport::find($report_id);
        if (null === $dailyreport) {
            return redirect('/');
        }

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item) {
            if (null === $item) {
                $form[$key] = '';
            }
        }

        // 遷移先を変更する。
        $transitionPreview = $form['transition-preview'];
        unset($form['transition-preview']);

        // データを詰め込む
        $dailyreport->fill($form)->save();
        $dailyreportId = $dailyreport->id;

        $redirectPath = '/';
        if ('true' === $transitionPreview) {
            $redirectPath = '/pdf/'.$dailyreportId;
        }

        return redirect($redirectPath);
    }

    public function copyReport(Request $request)
    {
        $dailyreport = Dailyreport::find($request->report_id);
        $dailyreport->date = date('Y-m-d');

        if (null === $dailyreport) {
            return redirect('/');
        }

        $constructions = Construction::all();

        $traders = self::fillTraders($dailyreport);

        $assets = self::fillAssets($dailyreport);

        return view('newreport', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets]);
    }

    public function deleteReport(Dailyreport $report_id)
    {
        if (!(Dailyreport::find($report_id))) {
            return redirect('/');
        }

        $report_id->delete();

        return redirect('/');
    }

    private function fillTraders($dailyreport)
    {
        $return_traders = [
            ['id' => '', 'name' => '業者名を選択してください'],
        ];
        $traders = Trader::where('department_id', $dailyreport->department_id)->get();
        foreach ($traders as $trader) {
            array_push(
                $return_traders,
                ['id' => $trader->id, 'name' => $trader->name]
            );
        }

        return $return_traders;
    }

    private function fillAssets($dailyreport)
    {
        $return_assets = [];
        for ($i = 1; $i <= 6; ++$i) {
            $individual_assets = [
                ['id' => '', 'name' => '業者名を選択してください'],
            ];

            $heavyMachineryTraderId = 'heavyMachineryTraderId'.$i;
            $trader_id = $dailyreport->{$heavyMachineryTraderId};
            $assets = Asset::where('trader_id', $trader_id)->get();
            foreach ($assets as $asset) {
                array_push(
                    $individual_assets,
                    ['id' => $asset->id, 'name' => $asset->name]
                );
            }

            $return_assets[] =
                $individual_assets
            ;
        }

        return $return_assets;
    }
}
