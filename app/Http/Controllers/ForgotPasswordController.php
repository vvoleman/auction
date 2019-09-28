<?php

namespace App\Http\Controllers;

use App\Custom\VerifyRules\ForgotPassword\IsTokenValid;
use App\Custom\VerifyRules\Verifier;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function create(){
        return view("login/forgot_password");
    }
    public function store(Request $request){
        $data = $request->validate([
            "email" => "required|email"
        ]);
        if(User::where('email',$data["email"])->first()){ //email existuje
            $token = Str::random(16);

            DB::table('password_resets')->insert([
                "email"=>$data["email"],
                "token"=>$token,
                "created_at"=>Carbon::now()
            ]);

            Mail::to($data["email"])->send(new \App\Mail\PasswordReset(route('forgot.edit',["token"=>$token])));
        }
        $request->session()->flash("success","Email s informacemi o resetování hesla byl odeslán!");
        return redirect()->route('home.home');
    }
    public function edit($token){
        $validToken = Verifier::check([IsTokenValid::check($token)]);
        if($validToken["value"]){
            return view('login/reset_password',["token"=>$token]);
        }
        \Session::flash('danger',$validToken["message"]);
        return redirect()->route('home.home');
    }
    public function update(Request $request, $token){
        $data = $request->validate([
            "password1"=>"required|min:8|max:64",
            "password2"=>"same:password1"
        ]);

        $validToken = Verifier::check([IsTokenValid::check($token)]);

        if($validToken["value"]){
            $email = DB::table('password_resets')->where('token',$token)->first()->email;
            $user = User::where('email',$email)->firstOrFail();
            $user->password = Hash::make($data["password1"]);
            $user->save();
            DB::table('password_resets')->where('token',$token)->update(["used_at"=>Carbon::now()]);
            $request->session()->flash("success","Heslo bylo úspěšně změněno!");
            Mail::to($email)->send(new \App\Mail\PasswordChanged());
        }else{
            $request->session()->flash("danger","Neplatný token!");
        }

        return redirect()->route('home.home');



    }
}
