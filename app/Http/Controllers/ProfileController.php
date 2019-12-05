<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Picture;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getProfile($uuid = null){
        if(empty($uuid)){
            $user = Auth::user();
            $you = true;
        }else{
            $user = User::where('uuid',$uuid)->firstOrFail();
            $you = false;
        }
        return view('profile/profile',["user"=>$user,"you"=>$you]);
    }

    public function getProfileImage(){
        return view('profile/profile_picture');
    }
    public function postOldProfileImage(Request $request){
        $data = $request->validate([
            "_data"=>"required|integer|exists:pictures,id_p"
        ]);
        $user = Auth::user();
        if(Picture::find($data["_data"])->creator_id == $user->id_u){
            $user->picture_id = $data["_data"];
            $user->save();
            return redirect()->route('profile.profile')->with('success','Profilový obrázek úspěšně změněn!');
        }else{
            return redirect()->route('profile.profileimg')->with('danger','Nebylo možné změnit profilový obrázek!');
        }
    }
    public function postNewProfileImage(Request $request){
        $data = $request->validate([
            "image"=>"required|image"
        ]);
        $abs = "images/profile_pictures";
        $ext = $data["image"]->extension();
        do{
            $path = Str::random('32');
        }while(Storage::exists($abs."/".$path.".".$ext));

        $data["image"]->storeAs("public/images/profile_pictures",$path.".".$ext);
        $user = Auth::user();
        $p = Picture::create([
            "picture_path"=>"/profile_pictures/".$path.".".$ext,
            "creator_id"=>$user->id_u,
            "type_id"=>1
        ]);
        $user->picture_id = $p->id_p;
        $user->save();

        return redirect()->route('profile.profile')->with('success','Profilový obrázek byl úspěšně změněn!');
    }
    public function getMyOffers(){
        return view('profile.my_offers');
    }
    public function ajaxGetMyOffers(Request $request){
        $data = $request->validate([
            "page"=>"required|integer",
            "order_by"=>"required|string",
            "dir" => "required|boolean"
        ]);
        $limit = 10;
        $user = Auth::user();
        //orderby - název, date,
        //filter - smazané, prodané, běžící, expirované
        $dir = ($data["dir"] == "0") ? "asc" : "desc";
        $q = $user->offers();
        switch ($data["order_by"]) {
            case 'name':
                $q->orderBy("name",$dir);
                break;
            case 'date':
                $q->orderBy("created_at",$dir);
                break;
        }
        $results = $q->skip($data["page"]*$limit)->take($limit);
        return $this->formatOffers($results);
    }
    private function formatOffers($data){
        return $data->get()->map(function($x){
            return [
                "name"=>$x->name,
                "img"=>($x->pictures()->count() > 0) ? $x->pictures[0]->path : null,
                "type"=>[
                    "id"=> $x->type->id_ot,
                    "name"=>$x->type->name
                ],
                "created_at"=>strtotime($x->created_at),
                "ended_at"=>strtotime($x->ended_at)
            ];
        });
    }
}
