<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Construction;

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
        return view('data_export.vender_create');
    }
}
