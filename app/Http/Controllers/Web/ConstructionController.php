<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Construction\StoreRequest;
use App\Http\Requests\ConstructionUpdateRequest;
use App\Models\Construction;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    public function index(Request $request)
    {
        function operator($value = null)
        {
            if ($value) {
                return '=';
            }

            return 'LIKE';
        }

        function word($value = null)
        {
            if ($value) {
                return $value;
            }

            return '%';
        }

        $constructions = Construction::where('number', operator($request->number), word($request->number))
            ->where('orderer', operator($request->orderer), word($request->orderer))
            ->where('place', operator($request->place), word($request->place))
            ->where('sales', operator($request->sales), word($request->sales))
            ->where('supervisor', operator($request->supervisor), word($request->supervisor))
            ->get()
        ;

        switch ($request->sort) {
            case '工期自早い順':
                $constructions = $constructions->sortBy('start');

                break;

            case '工期自遅い順':
                $constructions = $constructions->sortByDesc('start');

                break;

            case '工期至早い順':
                $constructions = $constructions->sortBy('end');

                break;

            case '工期至遅い順':
                $constructions = $constructions->sortByDesc('end');

                break;

            case '安い順':
                $constructions = $constructions->sortBy('price');

                break;

            case '高い順':
                $constructions = $constructions->sortByDesc('price');

                break;

            default:
                $constructions = $constructions->sortByDesc('end');
        }

        $constructionsPalams = [
            'number' => $request->number,
            'name' => $request->name,
            'orderer' => $request->orderer,
            'place' => $request->place,
            'sales' => $request->sales,
            'supervisor' => $request->supervisor,
            'sort' => $request->sort,
        ];

        $allConstructions = Construction::all();

        return view('construction.index', ['constructions' => $constructions, 'constructionsPalams' => $constructionsPalams, 'allConstructions' => $allConstructions]);
    }

    public function create()
    {
        $construction = new Construction();

        $constructions = Construction::all()->toArray();
        $construction_numbers = array_map(function ($element) {
            return $element['number'];
        }, $constructions);

        return view('construction.create_and_edit', ['construction' => $construction, 'construction_numbers' => $construction_numbers]);
    }

    public function store(StoreRequest $request)
    {
        $construction = new Construction();

        $form = $request->constructionAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item) {
            if (null === $item) {
                $form[$key] = '';
            }
        }

        // データを詰め込む
        $construction->fill($form)->save();

        // NOTE:パスワードを保存
        return redirect('/construction/password');
    }

    public function root(Request $request)
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

        $constructions = Construction::where('number', condition($request->number), value($request->number))
            ->where('orderer', condition($request->orderer), value($request->orderer))
            ->where('place', condition($request->place), value($request->place))
            ->where('sales', condition($request->sales), value($request->sales))
            ->where('supervisor', condition($request->supervisor), value($request->supervisor))
            ->get()
        ;

        switch ($request->sort) {
            case '工期自早い順':
                $constructions = $constructions->sortBy('start');

                break;

            case '工期自遅い順':
                $constructions = $constructions->sortByDesc('start');

                break;

            case '工期至早い順':
                $constructions = $constructions->sortBy('end');

                break;

            case '工期至遅い順':
                $constructions = $constructions->sortByDesc('end');

                break;

            case '安い順':
                $constructions = $constructions->sortBy('price');

                break;

            case '高い順':
                $constructions = $constructions->sortByDesc('price');

                break;

            default:
                $constructions = $constructions->sortByDesc('end');
        }

        $constructionsPalams = [
            'number' => $request->number,
            'name' => $request->name,
            'orderer' => $request->orderer,
            'place' => $request->place,
            'sales' => $request->sales,
            'supervisor' => $request->supervisor,
            'sort' => $request->sort,
        ];

        $allConstructions = Construction::all();

        if ('password' === $request->password) {
            return view('construction.index', ['constructions' => $constructions, 'user' => 'root', 'constructionsPalams' => $constructionsPalams, 'allConstructions' => $allConstructions]);
        }

        return view('construction.index', ['constructions' => $constructions, 'constructionsPalams' => $constructionsPalams, 'allConstructions' => $allConstructions]);
    }

    public function edit($constructionid)
    {
        $construction = Construction::find($constructionid);
        if (null === $construction) {
            return redirect('/construction');
        }

        $constructions = Construction::all()->toArray();
        $construction_numbers = array_map(function ($element) {
            return $element['number'];
        }, $constructions);

        return view('construction.create_and_edit', ['construction' => $construction, 'construction_numbers' => $construction_numbers]);
    }

    public function saveEditConstruction(ConstructionUpdateRequest $request, $constructionid)
    {
        $construction = Construction::find($constructionid);
        if (null === $construction) {
            return redirect('/construction');
        }

        $form = $request->constructionAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item) {
            if (null === $item) {
                $form[$key] = '';
            }
        }

        // データを詰め込む
        $construction->fill($form)->save();

        // NOTE:パスワードを保存
        return redirect('/construction/password');
    }

    public function deleteConstruction(Construction $constructionid)
    {
        if (!(Construction::find($constructionid))) {
            return redirect('/construction');
        }

        $constructionid->delete();

        // NOTE:パスワードを保存
        return redirect('/construction/password');
    }
}
