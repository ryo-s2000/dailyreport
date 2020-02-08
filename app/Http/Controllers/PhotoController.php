<?php

namespace App\Http\Controllers;

use App\Dailyreport;
use App\Construction;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request){
        function condition($value = null){
            if($value){
                return '=';
            } else {
                return 'LIKE';
            }
        }

        function value($value = null){
            if($value){
                return $value;
            } else {
                return '%';
            }
        }

        $dailyreports = Dailyreport::where('userName', condition($request->userName), value($request->userName))
            ->where('department', condition($request->department), value($request->department))
            ->where('constructionNumber', condition($request->constructionNumber), value($request->constructionNumber))
            ->get();
        switch ($request->sort){
            case '日付が早い順':
                $dailyreports = $dailyreports->sortByDesc('date');
                break;
            case '日付が遅い順':
                $dailyreports = $dailyreports->sortBy('date');
                break;
            default:
                $dailyreports = $dailyreports->sortByDesc('date');
        }

        $dailyreportsPalams = array(
            'userName' => $request->userName,
            'department' => $request->department,
            'constructionNumber' => $request->constructionNumber,
            'constructionName' => $request->constructionName,
            'sort' => $request->sort,
        );

        $allDailyreports = Dailyreport::all();
        $constructions = Construction::all();
        return view('photo', ["dailyreports" => $dailyreports, "dailyreportsPalams" => $dailyreportsPalams, "allDailyreports" => $allDailyreports, "constructions" => $constructions]);
    }
}
