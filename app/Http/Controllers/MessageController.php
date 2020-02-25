<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getMessage(){
        return view('messenger/messenger');
    }

    public function ajaxGetMessagesWith(Request $request){
        $data =  $request->validate([
            "with_id"=>"required|exists:users,id_u"
        ]);
        $user = Auth::user();
        $msgs = $user->messages_with(User::where('id_u',$data["with_id"])->first());
        return $msgs;
    }
    public function ajaxSentMessageTo(Request $request){
        $data =  $request->validate([
            "to"=>"required|exists:users,id_u",
            "message"=>"required"
        ]);

        $user = Auth::user();
        $msg = new Message([
            "from" => $user->id_u,
            "to"=>$data["to"],
            "message"=>$data["message"]
        ]);
        return $msg->save();
    }
}
