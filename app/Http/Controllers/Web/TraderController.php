<?php

namespace App\Http\Controllers\Web;

use App\Trader;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TraderController extends Controller
{
    public function index(Request $request){
        $traders = self::sort_traders(Trader::all());
        $assets = Asset::all();

        return view('edit_trader', ['traders' => $traders, 'assets' => $assets]);
    }

    private function sort_traders($trader_all){
        $sort = array();
        $traders = array();
        foreach ($trader_all as $index => $trader) {
            $sort[$index] = $trader->department_id;
            $traders[$index] = array(
                'id' => $trader->id,
                'department_id' => $trader->department_id,
                'name' => $trader->name
            );
        }
        array_multisort($sort, SORT_ASC, $traders);

        return $traders;
    }
}
