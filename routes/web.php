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

Route::get('/newreport', 'ReportController@newReport');

Route::get('/editreport/{reportid}', 'ReportController@editReport');

Route::post('/editreport/{reportid}', 'ReportController@saveEditReport');

Route::post('/newreport', 'ReportController@saveReport');

Route::get('/pdf/{reportid}', 'PdfController@createPdf');
