<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessage(){
        return view('messenger/messenger');
    }

    public function ajaxCreateMessage(Request $request){
        $data = $request->validate([
            "to"=>"required|exists:users,id_u",
            "from"=>"required|exists:users,id_u",
            "message"=>"required"
        ]);
        $user = User::find($data["from"]);
        $to = User::find($data["to"]);
        return $user->conversation_with($to);
    }
    public function ajaxGetContacts(){
        try{
            $user = Auth::user();
            $convers = $user->conversations;
            $toReturn = [];
            foreach($convers as $c){
                $o = $c->getOppositeUser($user);
                $toReturn[] = [
                    "user"=>[
                        "name"=>$o->fullname,
                        "img"=>$o->profpic_path()
                    ],
                    "last_msg"=>$c->messages()->orderBy("sent_at","desc")->first(),
                    "conversation_uuid"=>$c->uuid
                ];
            }
            return [
                "status"=>200,
                "data"=>$toReturn
            ];
        }catch(\Exception $e){
            return [
                "status"=>500,
                "data"=>[$e]
            ];
        }


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
            "to"=>"required|exists:conversations,id_c",
            "message"=>"required"
        ]);
        $c = Conversation::where('id_c',$data["to"])->first();
        $user = Auth::user();
        $msg = new Message([
            "from" => $user->id_u,
            "to"=>$c->getOppositeUser($user)->id_u,
            "uuid"=>$this->generateUUID("messages"),
            "conversation_id"=>$c->id_c,
            "message"=>$data["message"]
        ]);
        return $msg->save();
    }

    private function generateUUID($table){
        do{
            $str = Str::random(8);
        }while(DB::table($table)->where("uuid",$str)->exists());
        return $str;
    }
}
