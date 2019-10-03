<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailChangeController extends Controller
{
    public function store(Request $request){
        $data = $request->validate([
            "email"=>"required|email"
        ]);
        do{
            $token = Str::random(16);
        }while(!(DB::table("email_changes")->where("token",$token)->exists()));
        DB::table("email_changes")->insert([
            "user_id"=>$request->user()->id_u,
            "email"=>$data["email"],
            "token"=>$token
        ]);

    }
}
