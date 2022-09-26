<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\StoreRequest;
use App\Http\Requests\Report\StoreRequest as UpdateRequest;
use App\Models\Asset;
use App\Models\Construction;
use App\Models\Dailyreport;
use App\Models\Trader;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $dailyreports = Dailyreport::select('dailyreports.*', 'constructions.year as construction_year', 'constructions.number as construction_number', 'constructions.name as construction_name')
            ->join('constructions', 'dailyreports.construction_id', '=', 'constructions.id');

        // filter
        if ($request->year) $dailyreports = $dailyreports->where('constructions.year', $request->year);
        if ($request->userName) $dailyreports = $dailyreports->where('userName', $request->userName);
        if ($request->department_id) $dailyreports = $dailyreports->where('department_id', $request->department_id);
        if ($request->constructionNumber) $dailyreports = $dailyreports->where('constructions.id', $request->constructionNumber);

        // sort
        switch ($request->sort) {
            case '日付が早い順':
                $dailyreports = $dailyreports->orderBy('date')->orderByDesc('dailyreports.created_at');
                break;

            case '日付が遅い順':
                $dailyreports = $dailyreports->orderByDesc('date')->orderByDesc('dailyreports.created_at');
                break;

            default:
                $dailyreports = $dailyreports->orderByDesc('date')->orderByDesc('dailyreports.created_at');
        }

        // limit
        $limit = 100;
        if ($request->limit) $limit = $request->limit;

        $dailyreportsPalams = [
            'year' => $request->year,
            'userName' => $request->userName,
            'department_id' => $request->department_id,
            'constructionNumber' => $request->constructionNumber,
            'constructionName' => $request->constructionName,
            'sort' => $request->sort,
            'limit' => $limit,
        ];

        // TODO send userNames
        $allDailyreports = Dailyreport::all();
        $constructions = Construction::all();

        return view('report.top', ['dailyreports' => $dailyreports->paginate($limit), 'dailyreportsPalams' => $dailyreportsPalams, 'allDailyreports' => $allDailyreports, 'constructions' => $constructions, 'years' => config('common.years')]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $dailyreport = new Dailyreport();
        $dailyreport->date = date('Y-m-d');
        $constructions = Construction::orderBy('year')->get();
        $traders = [
            ['id' => '', 'name' => '部署を選択してください'],
        ];
        $assets = [];
        for ($i = 1; $i <= 6; ++$i) {
            $assets[] =
                [['id' => '', 'name' => '業者名を選択してください']]
            ;
        }

        return view('report.create_and_edit', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets, 'years' => config('common.years')]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreRequest $request)
    {
        $dailyreport = new Dailyreport();

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // nullを空文字に変更, 名前の空白を削除
        foreach ($form as $key => $item) {
            if ('userName' === $key) {
                $form['userName'] = str_replace([' ', '　'], '', $item);
            }

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

        $construction = Construction::find($dailyreport->construction_id);

        GoogleChatNotify((int) $form['department_id'], $form['userName'].'さんから'.$construction->name.'['.$construction->number.']'.'の日報が届きました。'.config('url.pdf').$dailyreportId);

        $redirectPath = '/';
        if ('true' === $transitionPreview) {
            $redirectPath = '/pdf/'.$dailyreportId;
        }

        return redirect($redirectPath);
    }

    /**
     * @param mixed $reportId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($reportId)
    {
        $dailyreport = Dailyreport::with(['construction'])->find($reportId);
        if (null === $dailyreport) {
            return redirect('/');
        }

        return view('report.show', ['dailyreport' => $dailyreport]);
    }

    /**
     * @param mixed $reportId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($reportId)
    {
        $dailyreport = Dailyreport::with(['construction'])->find($reportId);

        if (null === $dailyreport) {
            return redirect('/');
        }

        $constructions = Construction::all();

        $traders = self::fillTraders($dailyreport);

        $assets = self::fillAssets($dailyreport);

        return view('report.create_and_edit', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets, 'years' => config('common.years')]);
    }

    /**
     * @param mixed $reportId
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, $reportId)
    {
        $dailyreport = Dailyreport::find($reportId);
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

    /**
     * @param mixed $dailyreportId
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($dailyreportId)
    {
        Dailyreport::destroy($dailyreportId);

        return redirect('/');
    }

    /**
     * @param mixed $reportId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function createCopy($reportId)
    {
        $dailyreport = Dailyreport::with(['construction'])->find($reportId);
        $dailyreport->date = date('Y-m-d');

        if (null === $dailyreport) {
            return redirect('/');
        }

        $constructions = Construction::all();

        $traders = self::fillTraders($dailyreport);

        $assets = self::fillAssets($dailyreport);

        return view('report.create_and_edit', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets, 'years' => config('common.years')]);
    }

    /**
     * @psalm-return array{0: array{id: ''|mixed, name: '業者名を選択してください'|mixed}}
     *
     * @param mixed $dailyreport
     *
     * @return (mixed|string)[][]
     */
    private function fillTraders($dailyreport): array
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

    /**
     * @psalm-return non-empty-list<array{0: array{id: ''|mixed, name: '業者名を選択してください'|mixed}}>
     *
     * @param mixed $dailyreport
     *
     * @return (mixed|string)[][][]
     */
    private function fillAssets($dailyreport): array
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
