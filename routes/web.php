<?php

use App\Construction;

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

Route::get('/newpdf', function () {
    $constructions = Construction::all();
    $datetime = date("Y-m-d");
    return view('newpdf', ['datetime' => $datetime, "constructions" => $constructions]);
});

Route::post('/newpdf', 'PdfController@savePdf');

Route::get('/pdf', 'PdfController@createPdf');

Route::get('/', function () {
    return view('welcome');
});
