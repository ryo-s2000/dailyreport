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
Route::post('/data_exports/construction_number/unit_price', 'ConstructionNumberDataExportController@show');
Route::post('/data_exports/construction_number', 'ConstructionNumberDataExportController@export');
Route::post('/data_exports/vender/unit_price', 'VenderDataExportController@show');
Route::post('/data_exports/vender', 'VenderDataExportController@export');
