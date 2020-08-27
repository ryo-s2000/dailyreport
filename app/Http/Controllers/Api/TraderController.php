<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Trader;
use App\Http\Controllers\Controller;
use App\Http\Requests\TraderRequest;

class TraderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $department_id = $request->trader;
        $traders = Trader::where('department_id', $department_id)->get();
        return response()->json($traders);
    }

    public function store(TraderRequest $request)
    {
        $trader = new Trader;
        $form = $request->traderAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // データを詰め込む
        $trader->fill($form)->save();

        $traders = Trader::where('department_id', $request->department_id)->get();
        return response()->json($traders);
    }
}
