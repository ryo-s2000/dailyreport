<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

// report
Route::redirect('/', '/reports');
Route::prefix('reports')->group(function () {
    Route::get('/', 'ReportController@index');
    Route::get('/create', 'ReportController@create')->name('report.create');
    Route::post('/', 'ReportController@store')->name('report.store');
    Route::get('/{report_id}', 'ReportController@show')->name('report.show');
    Route::get('/{report_id}/edit', 'ReportController@edit')->name('report.edit');
    Route::post('/{report_id}/edit', 'ReportController@update')->name('report.update');
});

Route::get('/copyreport/{report_id}', 'ReportController@copyReport');

Route::delete('/delete/report/{report_id}', 'ReportController@deleteReport');
