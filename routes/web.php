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

Route::get('/', 'ReportController@index');

Route::get('/photo', 'PhotoController@index');

Route::get('/construction', 'ConstructionController@index');

Route::get('/newconstruction', 'ConstructionController@newConstruction');

Route::post('/newconstruction', 'ConstructionController@saveConstruction');

Route::get('/editconstruction/{constructionid}', 'ConstructionController@editConstruction');

Route::post('/editconstruction/{constructionid}', 'ConstructionController@saveEditConstruction');

Route::get('/newreport', 'ReportController@newReport');

Route::post('/newreport', 'ReportController@saveReport');

Route::get('/editreport/{reportid}', 'ReportController@editReport');

Route::post('/editreport/{reportid}', 'ReportController@saveEditReport');

Route::get('/pdf/{reportid}', 'PdfController@createPdf');
