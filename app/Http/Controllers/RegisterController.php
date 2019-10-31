<?php

namespace App\Http\Controllers;

use App\Notifications\AccountCreated;
use App\User;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function getRegister(){

        return view('login/register',["countries"=>Country::all()]);
    }
    public function postRegister(Request $request){

    	$data = $request->validate([
    		"firstname"=>"required|min:2|max:32",
    		"surname"=>"required|min:2|max:64",
    		"email"=>"required|email",
    		"password"=>"required|min:8|max:64",
            "password2"=>"same:password",
            "region_id"=>"integer|exists:regions,id_r",
            "zipcode"=>"required|postal_code:CZ,SK",
            "address"=>"required"
    	]); //validace

        if(!User::where('email',$data["email"])->exists()){
            $user = new User([
                "activation_token"=>$this->getRandom("activation_token",16),
                "uuid"=>$this->getRandom("uuid",8),
                "firstname"=>$data["firstname"],
                "surname"=>$data["surname"],
                "email"=>$data["email"],
                "password"=>Hash::make($data["password"]),
                "zipcode"=>intval($data["zipcode"]),
                "region_id"=>$data["region_id"],
                "address"=>$data["address"]
            ]); //vytvoří už. účet
            if($user->save()){
                try{
                    Mail::to($user->email)->send(new \App\Mail\AccountCreated(route("activate.activate",["token"=>$user->activation_token])));
                    $request->session()->flash('success', 'Účet byl vytvořen, nyní je potřeba ho potvrdit!');
                    return redirect()->route('home.home');
                }catch(\Exception $e){
                    $request->session()->flash('danger','Účet vytvořen, nebylo možné zaslat ověřovací email!');
                }
            }else{
                $request->session()->flash('danger', 'Účet nebylo možné vytvořit!');
            }
        }else{
            $request->session()->flash('danger', 'Email již existuje!');
        }

        return redirect()->route('register.register')->withInput($data);
    }
    private function getRandom($column,$length){
        do{
            $token = Str::random($length);
        }while(User::where($column,$token)->exists());
        return $token;
    }
}
