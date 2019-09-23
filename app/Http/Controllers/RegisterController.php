<?php

namespace App\Http\Controllers;

use App\Notifications\AccountCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function getRegister(){
        if(Auth::check()){
            return redirect("/");
        }

        return view('login/register');
    }
    public function postRegister(){
    	$data = request()->validate([
    		"firstname"=>"required|min:2|max:32",
    		"surname"=>"required|min:2|max:64",
    		"email"=>"required|email",
    		"password"=>"required|min:8|max:64",
            "password2"=>"same:password"
    	]); //validace

        if(!User::where('email',$data["email"])->exists()){
            do{
                $token = Str::random(16);
            }while(User::where('activation_token',$token)->exists()); //vygeneruje aktivační token
            $user = new User([
                "activation_token"=>$token,
                "firstname"=>$data["firstname"],
                "surname"=>$data["surname"],
                "email"=>$data["email"],
                "password"=>Hash::make($data["password"])
            ]); //vytvoří už. účet
            $user->notify(new AccountCreated());

        }


    }
}