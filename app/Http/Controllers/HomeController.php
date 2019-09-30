<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHome(){
        $g = Group::first();
        dd($g->permissions);
    	return view('home/home');
    }
}
