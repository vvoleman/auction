<?php

namespace App\Http\Controllers;

use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function getSetting(){
        $user = Auth::user();

        $data = [
            "email"=>$user->email,
            "firstname"=>$user->firstname,
            "surname"=>$user->surname,
            "address"=>[
                "region"=>1,
                "city"=>1
            ],
            "regions"=>Region::orderBy("name")->get()
        ];

        return view("setting/setting",$data);
    }
}
