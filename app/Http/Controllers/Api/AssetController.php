<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Asset;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $trader_id = $request->asset;
        $assets = Asset::where('trader_id', $trader_id)->get();
        return response()->json($assets);
    }

    public function store(AssetRequest $request)
    {
        $asset = new Asset;
        $form = $request->assetAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // データを詰め込む
        $asset->fill($form)->save();

        $assets = Asset::where('trader_id', $request->trader_id)->get();
        return response()->json($assets);
    }
}
