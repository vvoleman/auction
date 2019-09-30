<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function edit(){
        $user = Auth::user();

        $data = [
            "email"=>$user->email,
            "firstname"=>$user->firstname,
            "surname"=>$user->surname,
        ];

        return view("setting/setting",$data);
    }
}
