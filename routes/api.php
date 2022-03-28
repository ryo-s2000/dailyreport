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
    Route::resource('traders', 'TraderController', ['only' => ['show', 'store', 'edit']]);

    Route::resource('assets', 'AssetController', ['only' => ['show', 'store', 'edit']]);

    Route::post('/data_exports/unit_price', 'DataExportController@show');
    Route::post('/data_exports', 'DataExportController@export');
});
