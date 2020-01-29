<?php

namespace App\Http\Controllers;

use App\Dailyreport;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(){
        $dailyreports = Dailyreport::all();
        $dailyreportsSorted = $dailyreports->sortByDesc('date');
        // TODO もっと最適化できそう
        return view('photo', ["dailyreports" => $dailyreportsSorted]);
    }
}
