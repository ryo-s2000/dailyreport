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
        function condition($value = null): string
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

        $dailyreports = Dailyreport::select('dailyreports.*')->where('userName', condition($request->userName), value($request->userName))
            ->join('constructions', 'dailyreports.construction_id', '=', 'constructions.id')
            ->where('department_id', condition($request->department_id), value($request->department_id))
            ->where('constructions.number', condition($request->constructionNumber), value($request->constructionNumber))
        ;

        switch ($request->sort) {
            case '日付が早い順':
                $dailyreports = $dailyreports->orderBy('date')->orderByDesc('dailyreports.created_at')->paginate(100);

                break;

            case '日付が遅い順':
                $dailyreports = $dailyreports->orderByDesc('date')->orderByDesc('dailyreports.created_at')->paginate(100);

                break;

            default:
                $dailyreports = $dailyreports->orderByDesc('date')->orderByDesc('dailyreports.created_at')->paginate(100);
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

        lineNotify((int) $form['department_id'], $form['userName'].'さんから'.$form['constructionName'].'['.$form['constructionNumber'].']'.'の日報が届きました。'.config('url.pdf').$dailyreportId);
        GoogleChatNotify((int) $form['department_id'], $form['userName'].'さんから'.$form['constructionName'].'['.$form['constructionNumber'].']'.'の日報が届きました。'.config('url.pdf').$dailyreportId);

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

        return view('report.create_and_edit', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets]);
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

        return view('report.create_and_edit', ['dailyreport' => $dailyreport, 'constructions' => $constructions, 'traders' => $traders, 'assets' => $assets]);
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
