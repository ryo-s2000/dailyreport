<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Trader
Route::resource('traders', 'TraderController', ['only' => ['show', 'store', 'edit']]);

// Asset
Route::resource('assets', 'AssetController', ['only' => ['show', 'store', 'edit']]);

// Dataexport
Route::post('/data_exports/unit_price', 'DataExportController@show');
Route::post('/data_exports', 'DataExportController@export');
