<?php

namespace App\Http\Controllers;

use App\Group;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function getHome(){
    	return view('home/home');
    }
    public function getTest(){
        return view('home/test');
    }

    public function ajaxSetNotificationSeen(Request $request){
        $data = $request->validate([
            "seen"=>"required|boolean",
            "not_id"=>"required|exists:notifications,id_n"
        ]);

        $n = Notification::find($data["not_id"])->first();
        $u = $n->users()->where('user_id',Auth::id());

        if($u->first() != null){
            $res = DB::table('not_use')->where('user_id',Auth::id())->where('notification_id',$data["not_id"])->update(["seen_at"=>($data["seen"]) ? Carbon::now() : null]);
            return response()->json([],($res) ? 200 : 500);
        }
        return response()->json([],400);
    }
}
