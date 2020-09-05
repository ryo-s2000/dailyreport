<?php

use App\Construction;
use App\Dailyreport;

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

// photo
// Route::get('/photo', 'PhotoController@index');

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
Route::get('/newreport', 'ReportController@newReport');
Route::post('/newreport', 'ReportController@saveReport');
Route::get('/copyreport/{report_id}', 'ReportController@copyReport');

Route::get('/', 'ReportController@index');

Route::get('/editreport/{report_id}', 'ReportController@editReport');
Route::post('/editreport/{report_id}', 'ReportController@saveEditReport');

Route::delete('/delete/report/{report_id}', 'ReportController@deleteReport');

Route::get('/{report_id}', 'ReportController@showReport');
