<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Report
Route::redirect('/', '/reports');
Route::prefix('reports')->group(function () {
    Route::get('/', 'ReportController@index');
    Route::get('/create', 'ReportController@create')->name('report.create');
    Route::post('/', 'ReportController@store')->name('report.store');
    Route::get('/{report_id}', 'ReportController@show')->name('report.show');
    Route::get('/{report_id}/edit', 'ReportController@edit')->name('report.edit');
    Route::post('/{report_id}/edit', 'ReportController@update')->name('report.update');
    Route::delete('/{report_id}', 'ReportController@destroy')->name('report.destroy');

    Route::get('/create/copy/{report_id}', 'ReportController@createCopy')->name('report.create.copy');
});

// trader
Route::get('/edit_trader', 'TraderController@index');

// pdf
Route::get('/pdf/{report_id}', 'PdfController@createPdf');

// dataexport
Route::get('/dataexport', 'DataExportController@index');
Route::post('/dataexport', 'DataExportController@newdataexport');

// construction
Route::get('/newconstruction', 'ConstructionController@newConstruction');
Route::post('/newconstruction', 'ConstructionController@saveConstruction');

Route::get('/construction', 'ConstructionController@index');
Route::get('/construction/{password}', 'ConstructionController@root');

Route::get('/editconstruction/{constructionid}', 'ConstructionController@editConstruction');
Route::post('/editconstruction/{constructionid}', 'ConstructionController@saveEditConstruction');

Route::delete('/delete/construction/{constructionid}', 'ConstructionController@deleteConstruction');
