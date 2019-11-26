<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHome(){
    	return view('home/home');
    }
    public function getTest(){
        return view('home/test');
    }
}
