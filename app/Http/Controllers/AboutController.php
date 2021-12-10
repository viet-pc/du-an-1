<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AboutController extends Controller
{
    function index(){
        $data = DB::table('about')->first();
        return view('about', compact('data'));
    }
}
