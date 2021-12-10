<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SessionController extends Controller
{
    public function createsession(Request $request)
    {
        Session::put('Ship', $request->totalshipfee);

    }
    public function getshipfee($ShipOptionId)
    {
        $ship_fee = DB::table('shipoption')->where('ShipOptionId', '=', $ShipOptionId)->first();
        Session::put('city_check', $ship_fee->ShipOptionId);
        return $ship_fee->PricePerKm;
    }
}
