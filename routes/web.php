<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Report
Route::redirect('/', '/reports');
Route::resource('reports', 'ReportController');
Route::get('/reports/create/copy/{report}', 'ReportController@createCopy')->name('reports.create.copy');

// Construction
Route::resource('constructions', 'ConstructionController', ['except' => ['show']]);
Route::get('/constructions/{password}', 'ConstructionController@rootIndex');

// PDF
Route::get('/pdf/{report_id}', 'PdfController@generate');

/*
|-------------------
| With API
|-------------------
*/
// Trader
Route::get('/traders/edit', 'TraderController@edit')->name('traders.edit.all');

// Data Export
Route::get('/data_export/construction_number/create', 'DataExportController@construction_number_create')->name('data_export.construction_number.create');
Route::get('/data_export/vender/create', 'DataExportController@vender_create')->name('data_export.vender.create');
