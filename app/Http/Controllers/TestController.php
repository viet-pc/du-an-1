<?php

    namespace App\Http\Controllers;
    use App\Models\TestModels;

    class TestController extends Controller
    {
        public function test(){
            $data = TestModels::getData();
            $moredata = TestModels::getMoredata();
            return view('test', compact('data', 'moredata'));
        }

        public function index() {
            return view('welcome');
        }

    }

