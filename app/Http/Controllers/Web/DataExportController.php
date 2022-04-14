<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Construction;
use App\Models\Trader;

class DataExportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function construction_number_create()
    {
        $constructions = Construction::all();

        return view('data_export.construction_number_create', ['constructions' => $constructions]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vender_create()
    {
        $traders = Trader::select('id', 'name')->get();

        return view('data_export.vender_create', ['traders' => $traders]);
    }
}
