<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect("/");
        }

        return view('login/register');
    }
    public function create(){
    	$data = request()->validate([
    		"firstname"=>"required|min:2|max:32",
    		"surname"=>"required|min:2|max:64",
    		"email"=>"required|email",
    		"password"=>"required|min:8|max:64"
    	]);
    	dd($data);
    }
}
