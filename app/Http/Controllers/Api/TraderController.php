<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trader\StoreRequest;
use App\Models\Trader;
use Illuminate\Http\Request;

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

    public function store(StoreRequest $request)
    {
        $trader = new Trader();
        $form = $request->traderAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item) {
            if (null === $item) {
                $form[$key] = '';
            }
        }

        // データを詰め込む
        $trader->fill($form)->save();

        $traders = Trader::where('department_id', $request->department_id)->get();

        return response()->json($traders);
    }

    public function edit($id, Request $request)
    {
        $trader = Trader::find($id);
        if (null === $trader) {
            return response()->json([], 500);
        }
        $trader->name = $request->name;
        $trader->save();

        return response()->json();
    }
}
