<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class ActivationController extends Controller
{
    public function __invoke($token){
        try{
            $user = User::where("activation_token",$token)->firstOrFail();
            if($user->email_verified_at != null){
                return view('activation/already_verified');
            }
            $user->email_verified_at = Carbon::now();
            if($user->save()){
                return view('activation/success');
            }else{
                abort(500);
            }
        }catch(\Exception $e){
            return view('activation/invalid_token');
        }
    }
}
