<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api']], function(){
    Route::resource('traders', 'Api\TraderController', ['only' => ['show', 'store']]);

    Route::resource('assets', 'Api\AssetController', ['only' => ['show', 'store']]);

    Route::post('/data_exports/unit_price', 'Api\DataExportController@show');
    Route::post('/data_exports', 'Api\DataExportController@export');
});
