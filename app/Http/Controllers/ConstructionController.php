<?php

namespace App\Http\Controllers;

use App\Construction;
use Illuminate\Http\Request;
use App\Http\Requests\ConstructionRequest;
use App\Http\Requests\ConstructionUpdateRequest;

class ConstructionController extends Controller
{
    public function index(){
        $constructions = Construction::all();

        return view('construction', ["constructions" => $constructions]);
    }

    public function root(Request $request){
        $constructions = Construction::all();

        if($request->password == 'password'){
            return view('construction', ["constructions" => $constructions, "user" => 'root']);
        } else {
            return view('construction', ["constructions" => $constructions]);
        }
    }

    public function newConstruction(){
        $construction = new Construction;

        return view('newconstruction', ["construction" => $construction]);
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

        return view('newconstruction', ["construction" => $construction]);
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
