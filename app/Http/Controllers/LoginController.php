<?php

namespace App\Http\Controllers;

use App\Custom\VerifyRules\Login\IsAccountVerified;
use App\Custom\VerifyRules\Verifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function getLogin(){
        return view('login/login');
    }
    public function postLogin(Request $request){
        //validation
    	$data = $request->validate([
    		"email"=>"required|email",
    		"password"=>"required",
            "remember"=>"nullable"
    	]);
    	//setting remember
        $remember = $request->zapamatovat == "on";

        $user = User::where("email",$data["email"])->first();
        if($user != null && Hash::check($data["password"],$user->password)){
            $err = Verifier::check([IsAccountVerified::check($user)]);
            if($err["value"]){
                Auth::login($user,$remember);
                $user->last_logged = Carbon::now();
                $user->save();
                $request->session()->flash("success","Přihlášení proběhlo úspěšně!");
                return redirect()->route('home.home');
            }else{
                $errMessage = $err["message"];
            }
        }else{
            $errMessage = "Neplatné přihlašovací údaje!";
        }
        return redirect()->route('login.login')->with("danger",$errMessage)->withInput($data);

    }
    public function getLogout(){
        Auth::logout();
        request()->session()->flash("success","Odhlášení proběhlo úspěšně!");
        return redirect()->route('home.home');
    }


}
