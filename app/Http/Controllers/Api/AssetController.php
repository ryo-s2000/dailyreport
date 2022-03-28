<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreRequest;
use App\Models\Asset;
use Illuminate\Http\Request;

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

    public function store(StoreRequest $request)
    {
        $asset = new Asset();
        $form = $request->assetAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item) {
            if (null === $item) {
                $form[$key] = '';
            }
        }

        // データを詰め込む
        $asset->fill($form)->save();

        $assets = Asset::where('trader_id', $request->trader_id)->get();

        return response()->json($assets);
    }

    public function edit($id, Request $request)
    {
        $asset = Asset::find($id);
        if (null === $asset) {
            return response()->json([], 500);
        }
        $asset->name = $request->name;
        $asset->save();

        return response()->json();
    }
}
