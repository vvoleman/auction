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
    	//setting remember and deleting remember if exists
        $remember = (isset($data["remember"])) ? true : false;
        if(isset($data["remember"])) unset($data["remember"]);

        //finds user by email
        $user = User::where("email",$data["email"])->first();
        //checks if user exists or if password is right
        if($user != null && Hash::check($data["password"],$user->password)){
            //runs through all condition for login and returns first error
            $err = Verifier::check([IsAccountVerified::check($user)]);
            //if there is no error, user will be logged, otherwise errMessage will be filled
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
        $request->session()->flash("danger",$errMessage);
        return redirect()->route('login.create')->withInput($data);

    }
    public function getLogout(){
        Auth::logout();
        request()->session()->flash("success","Odhlášení proběhlo úspěšně!");
        return redirect()->route('home.home');
    }


}
