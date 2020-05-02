<?php

namespace App\Http\Controllers;

use App\Construction;
use Illuminate\Http\Request;
use App\Http\Requests\ConstructionRequest;
use App\Http\Requests\ConstructionUpdateRequest;

class ConstructionController extends Controller
{
    public function index(Request $request){
        function condition($value = null){
            if($value){
                return '=';
            } else {
                return 'LIKE';
            }
        }

        function value($value = null){
            if($value){
                return $value;
            } else {
                return '%';
            }
        }

        $constructions = Construction::where('number', condition($request->number), value($request->number))
            ->where('orderer', condition($request->orderer), value($request->orderer))
            ->where('place', condition($request->place), value($request->place))
            ->where('sales', condition($request->sales), value($request->sales))
            ->where('supervisor', condition($request->supervisor), value($request->supervisor))
            ->get();
        switch ($request->sort){
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

        $constructionsPalams = array(
            'number' => $request->number,
            'name' => $request->name,
            'orderer' => $request->orderer,
            'place' => $request->place,
            'sales' => $request->sales,
            'supervisor' => $request->supervisor,
            'sort' => $request->sort,
        );

        $allConstructions = Construction::all();

        return view('construction', ['constructions' => $constructions, 'constructionsPalams' => $constructionsPalams, 'allConstructions' => $allConstructions]);
    }

    public function root(Request $request){
        function condition($value = null){
            if($value){
                return '=';
            } else {
                return 'LIKE';
            }
        }

        function value($value = null){
            if($value){
                return $value;
            } else {
                return '%';
            }
        }

        $constructions = Construction::where('number', condition($request->number), value($request->number))
            ->where('orderer', condition($request->orderer), value($request->orderer))
            ->where('place', condition($request->place), value($request->place))
            ->where('sales', condition($request->sales), value($request->sales))
            ->where('supervisor', condition($request->supervisor), value($request->supervisor))
            ->get();
        switch ($request->sort){
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

        $constructionsPalams = array(
            'number' => $request->number,
            'name' => $request->name,
            'orderer' => $request->orderer,
            'place' => $request->place,
            'sales' => $request->sales,
            'supervisor' => $request->supervisor,
            'sort' => $request->sort,
        );

        $allConstructions = Construction::all();

        if($request->password == 'password'){
            return view('construction', ['constructions' => $constructions, "user" => 'root', 'constructionsPalams' => $constructionsPalams, 'allConstructions' => $allConstructions]);
        } else {
            return view('construction', ['constructions' => $constructions, 'constructionsPalams' => $constructionsPalams, 'allConstructions' => $allConstructions]);
        }
    }

    public function newConstruction(){
        $construction = new Construction;

        $constructions = Construction::all()->toArray();
        $construction_numbers = array_map(function($element){
            return $element['number'];
        }, $constructions);

        return view('newconstruction', ["construction" => $construction, "construction_numbers" => $construction_numbers]);
    }

    public function saveConstruction(ConstructionRequest $request){
        $construction = new Construction;

        $form = $request->constructionAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // データを詰め込む
        $construction->fill($form)->save();

        // NOTE:パスワードを保存
        return redirect('/construction/password');
    }

    public function editConstruction($constructionid){
        $construction = Construction::find($constructionid);
        if($construction == null){
            return redirect('/construction');
        }

        $constructions = Construction::all()->toArray();
        $construction_numbers = array_map(function($element){
            return $element['number'];
        }, $constructions);

        return view('newconstruction', ["construction" => $construction, "construction_numbers" => $construction_numbers]);
    }

    public function saveEditConstruction(ConstructionUpdateRequest $request, $constructionid){
        $construction = Construction::find($constructionid);
        if($construction == null){
            return redirect('/construction');
        }

        $form = $request->constructionAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // データを詰め込む
        $construction->fill($form)->save();

        // NOTE:パスワードを保存
        return redirect('/construction/password');
    }

    public function deleteConstruction(Construction $constructionid){
        if( !(Construction::find($constructionid)) ){
            return redirect('/construction');
        }

        $constructionid->delete();

        // NOTE:パスワードを保存
        return redirect('/construction/password');
    }
}
