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
Route::get('/newconstruction', 'ConstructionController@newConstruction');
Route::post('/newconstruction', 'ConstructionController@saveConstruction');

Route::get('/construction', 'ConstructionController@index');
Route::get('/construction/{password}', 'ConstructionController@root');

Route::get('/editconstruction/{constructionid}', 'ConstructionController@editConstruction');
Route::post('/editconstruction/{constructionid}', 'ConstructionController@saveEditConstruction');

Route::delete('/delete/construction/{constructionid}', 'ConstructionController@deleteConstruction');

// PDF
Route::get('/pdf/{report_id}', 'PdfController@createPdf');

/*
|-------------------
| With API
|-------------------
*/
// Trader
Route::get('/edit_trader', 'TraderController@index');

// Data Export
Route::get('/data_export/create', 'DataExportController@create')->name('data_export.create');
Route::post('/data_export', 'DataExportController@generate')->name('data_export.generate');
