<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Construction;

class DataExportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $constructions = Construction::all();

        return view('data_export.create', ['constructions' => $constructions]);
    }
}
