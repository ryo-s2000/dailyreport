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
Route::get('/photo', 'PhotoController@index');

// pdf
Route::get('/pdf/{reportid}', 'PdfController@createPdf');

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
Route::get('/copyreport/{reportid}', 'ReportController@copyReport');

Route::get('/', 'ReportController@index');

Route::get('/editreport/{reportid}', 'ReportController@editReport');
Route::post('/editreport/{reportid}', 'ReportController@saveEditReport');

Route::delete('/delete/report/{reportid}', 'ReportController@deleteReport');

// detail report
Route::get('/newsignature/{reportid}', 'SignatureController@newSignature');
Route::post('/newsignature/{reportid}', 'SignatureController@saveSignature');

Route::get('/{reportid}', 'ReportController@showReport');

Route::get('/editsignature/{signatureid}', 'SignatureController@editSignature');
Route::post('/editsignature/{signatureid}', 'SignatureController@saveEditSignature');

Route::delete('/delete/signature/{signatureid}/{reportid}', 'SignatureController@deleteSignature');
