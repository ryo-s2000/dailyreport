<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Trader;
use Illuminate\Http\Request;

class TraderController extends Controller
{
    public function edit(Request $request)
    {
        $traders = self::sort_traders(Trader::all());
        $assets = Asset::all();

        return view('trader.edit', ['traders' => $traders, 'assets' => $assets]);
    }

    private function sort_traders($trader_all)
    {
        $sort = [];
        $traders = [];
        foreach ($trader_all as $index => $trader) {
            $sort[$index] = $trader->department_id;
            $traders[$index] = [
                'id' => $trader->id,
                'department_id' => $trader->department_id,
                'name' => $trader->name,
            ];
        }
        array_multisort($sort, SORT_ASC, $traders);

        return $traders;
    }
}
