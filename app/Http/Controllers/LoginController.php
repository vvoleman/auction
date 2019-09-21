<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function getLogin(){
        if(Auth::check()){
            return redirect("/");
        }

        return view('login/login');
    }
   /* public function postLogin(){
    	$data = request()->validate([
    		"email"=>"required|email",
    		"password"=>"required"
    	]);
    	$data["active"] = 1;
    	if(Auth::attempt($data))
    } */
    public function getRegister(){
        if(Auth::check()){
            return redirect("/");
        }

        return view('login/register');
    }

}
