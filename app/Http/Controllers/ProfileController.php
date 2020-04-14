<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Picture;
use App\Offer;
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
            $you = Auth::user()->uuid == $uuid;
        }
        $offer = $this->formatOffers((($you) ? $user->offers() : $user->offers()->whereNull('delete_reason'))->orderBy('created_at','DESC')->take(6));
        return view('profile/profile',["user"=>$user,"you"=>$you,"offers"=>$offer]);
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
    public function getMyOrders(){
        return view('profile.my_orders');
    }
    public function ajaxGetMyOffers(Request $request){
        $data = $request->validate([
            "page"=>"required|integer",
            "order_by"=>"required|string",
            "dir" => "required|boolean",
            "filter"=>"required|string"
        ]);
        $limit = 9;
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
            default:
                return response('Invalid argument',422);
        }
        switch ($data["filter"]){
            case "deleted":
                $q->where('delete_reason','!=',null);
                break;
            case "active":
                $q->where('delete_reason',null)->where('end_date','>',Carbon::now());
                break;
            case "expired":
                $q->where('end_date','<',Carbon::now());
                break;
            case "sold":
                $q->whereNotNull('sold_to');
                break;
            default:
                break;
        }
        $count = $q->count();
        $results = $q->skip($data["page"]*$limit)->take($limit);
        $results = $this->formatOffers($results);
        return [
            "count"=>$count,
            "data"=>$results,
            "next_page"=>($count > ($data["page"]*$limit+$limit)) ? intval($data["page"])+1 : false
        ];
    }
    public function ajaxGetMyOrders(Request $request){
        $data = $request->validate([
            "page"=>"required|integer",
            "order_by"=>"required|string",
            "dir" => "required|boolean",
            "filter"=>"required|string"
        ]);
        $limit = 9;
        $user = Auth::user();
        //orderby - název, date,
        //filter - smazané, prodané, běžící, expirované
        $dir = ($data["dir"] == "0") ? "asc" : "desc";
        $q = $user->bought()->whereNull('deleted_at');
        switch ($data["order_by"]) {
            case 'name':
                $q->orderBy("name",$dir);
                break;
            case 'date':
                $q->orderBy("created_at",$dir);
                break;
            default:
                return response('Invalid argument',422);
        }
        switch ($data["filter"]){
            case "waiting":
                $q->whereNull('confirmed_at')
                    ->whereNull('denied_at');
                break;
            case "confirmed":
                $q->whereNotNull('confirmed_at')
                    ->whereNull('denied_at')
                    ->whereNull('received_at');
                break;
            case "denied":
                $q->whereNotNull('denied_at');
                break;
            case "shipped":
                $q->whereNotNull('shipped_at')
                    ->whereNull('received_at');
                break;
            case "finished":
                $q->whereNotNull('received_at');
            default:
                break;
        }
        $count = $q->count();
        $results = $q->skip($data["page"]*$limit)->take($limit);
        $results = $this->formatSells($results);
        return [
            "count"=>$count,
            "data"=>$results,
            "next_page"=>($count > ($data["page"]*$limit+$limit)) ? intval($data["page"])+1 : false
        ];
    }

    private function formatOffers($data){
        return $data->get()->map(function($x){
            $temp = $x->sells()->whereNull('deleted_at')->count();
            return [
                "name"=>$x->name,
                "picture"=>$x->safe_pictures()[0],
                "url"=>route('offers.offer',["id"=>$x->uuid]),
                "status"=>$this->getStatus($x),
                "type"=>[
                    "id"=> $x->type->id_ot,
                    "name"=>$x->type->name
                ],
                "offersell_amount"=>$temp,
                "price"=>$x->price,
                "currency"=>$x->currency->short,
                "category"=>$x->category->name,
                "id"=>$x->id_o,
                "delivery"=>$x->delivery_type->label,
                "payment"=>$x->payment_type->label,

                "created_at"=>$x->created_at->timestamp,
                "end_date"=>$x->end_date->timestamp
            ];
        });
    }
    private function formatSells($data){
        return $data->get()->map(function($x){
            return [
                "name"=>$x->offer->name,
                "picture"=>$x->offer->safe_pictures()[0],
                "url"=>route('offersell.offersell',["uuid"=>$x->id_os ]),
                "status"=>$x->getStatus(),
                "price"=>$x->offer->price,
                "currency"=>$x->offer->currency->short,
                "category"=>$x->offer->category->label,
                "id"=>$x->id_os,
                "delivery"=>$x->offer->delivery_type->label,
                "payment"=>$x->offer->payment_type->label,

                "created_at"=>$x->offer->created_at->timestamp,
                "changed_at"=>$x->getStatusTimestamp()
            ];
        });
    }
    private function getStatus(Offer $o){
        if($o->delete_reason == null){
            if($o->end_date >= Carbon::now()){
                if($o->sold_to != null){
                    return "sold";
                }
                return "active";
            }else{
                return "expired";
            }
        }else{
            return "deleted";
        }
    }
}
