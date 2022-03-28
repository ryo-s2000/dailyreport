<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Construction\StoreRequest;
use App\Http\Requests\Construction\UpdateRequest;
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

    public function update(UpdateRequest $request, $constructionid)
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

    public function destroy(Construction $constructionId)
    {
        Construction::destroy($constructionId);

        // NOTE:パスワードを保存
        return redirect('/construction/password');
    }

    public function rootIndex(Request $request)
    {
        // TODO fix auth

        function oper($value = null)
        {
            if ($value) {
                return '=';
            }

            return 'LIKE';
        }

        function v($value = null)
        {
            if ($value) {
                return $value;
            }

            return '%';
        }

        $constructions = Construction::where('number', oper($request->number), v($request->number))
            ->where('orderer', oper($request->orderer), v($request->orderer))
            ->where('place', oper($request->place), v($request->place))
            ->where('sales', oper($request->sales), v($request->sales))
            ->where('supervisor', oper($request->supervisor), v($request->supervisor))
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
}
