<?php

namespace App\Http\Controllers;

use App\Custom\Uuidable;
use App\Helpanswer;
use App\Helpthread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpdeskController extends Controller
{
    use Uuidable;
    //API
    public function ajaxGetThreads(Request $request){
        $data = $request->validate([
            "query"=>"required|string",
            "page"=>"required|integer",
            "onlyUnfinished"=>"required|boolean"
        ]);

        $limit = 10;
        $q = Helpthread::where("title","like","%".$data["query"]."%");
        if($data["onlyUnfinished"]) $q->whereNull('answer');
        $count = $q->count();
        $results = $q->skip($data["page"]*$limit)->take($limit)->get()->map(function($x){
            return $this->formatThread($x);
        });

        return [
            "data"=>$results,
            "next"=>($count-($data["page"]*$limit) > 0) ? $data["page"]+1 : false
        ];
    }

    public function ajaxAddThread(Request $request){
        $data = $request->validate([
            "title"=>"required|string",
            "text"=>"required|string"
        ]);

        $ht = new Helpthread([
            "title"=>$data["title"],
            "text"=>$data["text"],
            "author_id"=>Auth::id(),
            "uuid"=>$this->generateUUID("helpthreads")
        ]);

        if($ht->save()){
            $ht = $ht->fresh();
            return [
                "response"=>200,
                "thread"=>$this->formatThread($ht)
            ];
        }else{
            return [
                "response"=>500
            ];
        }
    }

    public function ajaxReplyOnThread(Request $request){
        $data = $request->validate([
            "ht_uuid"=>"required|exists:helpthreads,uuid",
            "text"=>"required|string"
        ]);

        $ht = Helpthread::where('uuid',$data["ht_uuid"])->first();

        if($ht->answer != null){
            $err_msg = "Na vlákno již nelze odpovídat!";
            $code = 400;
        }else{
            $ha = new Helpanswer([
                "author_id"=>Auth::id(),
                "text"=>$data["text"],
                "thread_id"=>$ht->id_ht,
                "uuid"=>$this->generateUUID("helpanswers")
            ]);

            if($ha->save()){
                return [
                    "response"=>200,
                    "data"=>[]
                ];
            }else{
                $err_msg = "Nelze přidat odpověď!";
                $code = 500;
            }
        }
        return [
            "response"=> $code,
            "error"=> $err_msg
        ];



    }

    public function ajaxMarkAsAnswered(Request $request){
        $data = $request->validate([
            "ha_uuid"=>"required|exists:helpanswers,uuid",
        ]);

        $ha = Helpthread::where('uuid',$data["ht_uuid"])->first();
        $ha->thread->answer_id = $ha->id_ht;
        if($ha->save()){
            return [
                "response"=>200,
                "answer"=>$ha->uuid
            ];
        }else{
            return [
                "response"=>500
            ];
        }
    }

    private function formatThread($ht){
        return [
            "ht_uuid"=>$ht->uuid,
            "title"=>$ht->title,
            "text"=>$ht->text,
            "author"=>[
                "fullname"=>$ht->author->fullname,
                "img"=>$ht->author->profpic_path()
            ],
            "created_at"=>$ht->created_at->timestamp,
            "responses"=>$ht->answers()->count(),
            "answered"=>($ht->answer != null)
        ];
    }
}
