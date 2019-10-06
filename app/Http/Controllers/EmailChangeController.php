<?php

namespace App\Http\Controllers;

use App\Custom\VerifyRules\EmailChange\IsTokenValid;
use App\Custom\VerifyRules\Verifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmailChangeController extends Controller
{
    public function store(Request $request){
        $data = $request->validate([
            "email"=>"required|email"
        ]);
        do{
            $token = Str::random(16);
        }while((DB::table("email_changes")->where("token",$token)->exists()));
        DB::table("email_changes")->insert([
            "user_id"=>$request->user()->id_u,
            "email"=>$data["email"],
            "token"=>$token
        ]);
        try{
            Mail::to($data["email"])->send(new \App\Mail\EmailChange(route('emailchange.edit',["token"=>$token])));

            $request->session()->flash("success","Odkaz pro změnu emailu vám byl odeslán na nový mail!");
        }catch(\Exception $e){
            $request->session()->flash("danger","Nebylo možné vytvořit token pro nový email!");
        }
        return redirect()->route("setting.edit");
    }
    public function edit(Request $request, $token){
        $validToken = Verifier::check([IsTokenValid::check($token)]);
        if($validToken["value"]){

            $email = DB::table('email_changes')->select('email')->where('token',$token)->first()->email;
            $user = Auth::user();
            $user->email = $email;
            $user->save();
            DB::table('email_changes')->where('token',$token)->update(["verified_at"=>Carbon::now()]);
            Auth::logout();
            $request->session()->flash("success","Email byl úspěšně změněn! Nyní se můžete přihlásit s novým emailem!");
        }else{
            $request->session()->flash("danger",$validToken["message"]);
        }
        return redirect()->route('home.home');
    }
}
