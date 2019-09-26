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
    public function postLogin(){
    	$data = request()->validate([
    		"email"=>"required|email",
    		"password"=>"required",
            "remember"=>"nullable"
    	]); //validation
    	if(isset($data["remember"])){
    	    $remember = true;
    	    unset($data["remember"]);
        }else{
    	    $remember = false;
        } //mapping of remember
        if(Auth::attemp($data,$remember)){

        }
    }


}
