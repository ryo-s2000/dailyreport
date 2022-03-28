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
Route::get('/data_export/create', 'DataExportController@create')->name('data_export.create');
Route::post('/data_export', 'DataExportController@generate')->name('data_export.generate');
