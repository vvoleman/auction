<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\ChangeIndicator;
use App\Events\NewMessage;
use App\Events\NewOffersellMessage;
use App\Message;
use App\OfferSell;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Notification;
use App\Events\NewNotification;

class MessageController extends Controller
{
    public function getMessage(){
        return view('messenger/messenger');
    }

    public function ajaxGetUsers(Request $request){
        $data = $request->validate([
            "string"=>"nullable"
        ]);
        if(empty($data["string"])) $data["string"] = "";
        try{
            $result = User::selectRaw(DB::raw("CONCAT(firstname,' ',surname) as label,uuid as code"))->whereRaw('CONCAT(firstname," ",surname) LIKE "%'.htmlspecialchars($data["string"]).'%"'/*,[$data["string"]]*/)->where('id_u','!=',Auth::id())->orderBy("surname","asc")->orderBy("firstname","asc")->get();
            return [
                "status"=>200,
                "data"=>$result
            ];
        }catch (\Exception $e){
            return [
                "status"=>500,
                "error"=>$e
            ];
        }

    }
    public function ajaxCreateMessage(Request $request){
        $data = $request->validate([
            "to"=>"required|exists:users,uuid",
            "message"=>"required",
            "offersell_id"=>"sometimes|required|exists:offer_sells,id_os"
        ]);
        $user = Auth::user();
        $to = User::where('uuid',$data["to"])->first();
        $c = $user->conversation_with($to);
        if(!isset($data["offersell_id"])) $data["offersell_id"] = null;
        $new = false;
        try{
            if($user->id_u == $to->id_u) throw new Exception();
            if($c == null){
                $new = true;
                $c = new Conversation([
                    "color_id"=>1,
                    "uuid"=>$this->generateUUID("conversations")
                ]);
                $c->save();
                $c->users()->attach([$user->id_u,$to->id_u]);
            }
            $msg = new Message([
                "conversation_id"=>$c->id_c,
                "message"=>$data["message"],
                "from"=>$user->id_u,
                "to"=>$to->id_u,
                "uuid"=>$this->generateUUID("messages"),
                "sent_at"=>Carbon::now(),
                "offersell_id"=>$data["offersell_id"]
            ]);
            $msg->save();
            $c->updated_at = Carbon::now();
            if($c->save()){
                $ff = $this->generateMessage($msg,true);
                $ff["you"] = !$ff["you"];

                if($data["offersell_id"] == null){
                    event(new NewMessage($msg->to_user->uuid,($msg->offersell != null),["msg"=>$ff,"conversation_uuid"=>$c->uuid]));
                }else{
                    $os = OfferSell::where('id_os',$data["offersell_id"])->first();
                    event(new NewOffersellMessage([
                        "message"=>$msg->message,
                        "author"=>$msg->from_user->uuid,
                        "message_uuid"=>$msg->uuid,
                        "created_at"=>Carbon::now()->format("H:i")
                    ],$os->id_os));
                    event(new NewNotification($to,[
                        "type_id"=>2,
                        "notification"=>"Nová zpráva v objednávce '".$os->offer->name."'",
                        "url"=>route('offersell.offersell',["uuid"=>$os->id_os])
                    ]));
                }
            }
            $temp = [
                "status"=>200
            ];
            $temp["data"] = $this->generateContact($to,$c,$new);

            return $temp;
        }catch(\Exception $e){
            return [
                "status"=>500,
                "error"=>$e->getTrace()
            ];
        }


    }
    public function ajaxGetContacts(){
        try{
            $user = Auth::user();
            $convers = $user->conversations()->orderBy("updated_at","desc")->get();
            $toReturn = [];
            foreach($convers as $c){
                $o = $c->getOppositeUser($user);
                $toReturn[] = $this->generateContact($o,$c,true);
            }
            return [
                "status"=>200,
                "data"=>$toReturn,
                "you"=>[
                    "name"=>$user->fullname,
                    "uuid"=>$user->uuid,
                    "img"=>$user->profpic_path()
                ]
            ];
        }catch(\Exception $e){
            return [
                "status"=>500,
                "error"=>$e->getMessage()
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
    public function ajaxGetOfferMessagesWith(Request $request){
        $data =  $request->validate([
            "with_uuid"=>"required|exists:users,uuid",
            "os_id"=>"required|exists:offer_sells,id_os"
        ]);
        $you = Auth::user();
        $opp = User::where('uuid',$data["with_uuid"])->first();

        $c = $you->conversation_with($opp);
        if($c == null){
            return [];
        }else{
            return $c->messages()->where('offersell_id',$data["os_id"])->get()->map(function($x){
                return $this->generateMessage($x,true);
            });
        }
    }
    public function ajaxGetConversation(Request $request){
        $data = $request->validate([
            "c_uuid"=>"required|exists:conversations,uuid",
            "start"=>"required|integer"
        ]);

        $limit = 10;

        try{
            $c = Conversation::where('uuid',$data["c_uuid"])->first();
            $count = $c->messages()->count();
            $res = $c->messages()
                ->whereNull('offersell_id')
                ->orderBy('sent_at',"desc")
                /*->skip($data["start"])
                ->take($limit)*/
                ->get();

            return [
                "status"=>200,
                "data"=>$res->map(function($x){return $this->generateMessage($x);}),
                "next"=>(($count - (1 + $data["start"]) * $limit) > 0) ? $data["start"] + 1 : false,
            ];
        }catch (\Exception $e){
            //return $e;
            return [
                "status"=>500,
                "error"=>$e->getMessage()
            ];
        }

    }
    public function ajaxMarkAsSeen(Request $request){
        $data = $request->validate([
            "uuids"=>"required|array"
        ]);
        $done = Message::whereIn("uuid",$data["uuids"])->update(["seen_at"=>Carbon::now()]);
        if($done){
            $user = Message::where('uuid',$data["uuids"][0])->first()->to_user;
            event(new ChangeIndicator($user->unread_conversations(),$user->uuid));
        }
        return [
            "status"=>($done) ? 200 : 500,
            "data"=>$done
        ];

    }

    private function generateUUID($table){
        do{
            $str = Str::random(8);
        }while(DB::table($table)->where("uuid",$str)->exists());
        return $str;
    }
    private function getDateString($d){
        $carbon = Carbon::now();
        if($d->diffInHours($carbon) < 24){ //hours ago
            $time = $d->format("H:i");
        }else if($d->diffInDays($carbon) < 7){ //days ago
            $format = [
                "po","út","st","čt","pá","so","ne"
            ];
            $time = $format[$d->dayOfWeek];
        }else if($d->diffInYears($carbon) < 1){ //weeks ago
            $time = $d->format("d. m.");
        }else{
            $time = $d->format("d. m. y");
        }
        return $time;
    }
    private function generateContact($u,$c,$includeUser){
        $last = $c->messages()->orderBy("sent_at","desc")->first();
        $temp = [
            "last_msg"=>$this->generateMessage($last,true),
            "conversation_uuid"=>$c->uuid
        ];

        if($includeUser){
            $temp["user"] = [
                "name"=>$u->fullname,
                "img"=>$u->profpic_path(),
                "uuid"=>$u->uuid
            ];
        }

        return $temp;
    }
    private function generateMessage($msg,$short = false){
        $uuid = Auth::user()->uuid;
        $temp = [
            "message_uuid"=>$msg->uuid,
            "you"=>$msg->from_user->uuid == $uuid,
            "author"=>$msg->from_user->uuid,
            "message"=>$msg->message,
            "sent_at"=>($short) ? $this->getDateString($msg->sent_at) : $msg->sent_at->format("d.m.y H:i"),
            "seen_at"=>($msg->seen_at != null) ? $msg->seen_at->format("d.m.y H:i") : null
        ];
        if($msg->offer_id != null){
            $o = $msg->offer;
            $temp["offer"] = [
                "name"=>$o->name,
                "image"=>$o->safe_pictures()[0],
                "url"=>route("offers.offer",["id"=>$o->uuid]),
                "desc"=>Str::words($o->description,20),
                "price"=>$o->price,
                "currency"=>$o->currency->short
            ];
        }
        return $temp;
    }
}
