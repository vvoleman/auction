<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Offer;
use App\Custom\Translator;
use App\Http\Requests\NewOffer;
use App\OfferType;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function getNewOffer(){
        $data = [
            "types"=>OfferType::all(),
            "curr"=>[
                "all"=>Currency::all(),
                "selected"=>Auth::user()->country->currency
            ]
        ];
        return view('offer/new_offer',$data);
    }
    public function postNewOffer(NewOffer $request){
        $data = $request->validated();
        $tags = json_decode($data["_tags"]);
        $ids = [];
        foreach($tags as $t){
            if(true /*preg_match("/pL/",$t)*/){
                if(Tag::where('name',$t)->exists()){
                    $ids[] = Tag::where('name',$t)->first()->id_t;
                }else{
                    $tag = new Tag([
                        "name"=>$t
                    ]);
                    $tag->save();
                    $ids[] = $tag->id_t;
                }
            }
        }
        $uuid = $this->generateUuid();
        $offer = new Offer([
            "name"=>$data["name"],
            "type_id"=>$data["type"],
            "price"=>$data["price"],
            "description"=>$data["description"],
            "end_date"=>$data["end_date"],
            "uuid"=>$uuid,
            "currency_id"=>$data["currency"],
            "owner_id"=>Auth::user()->id_u
        ]);
        if($offer->save()){
            $offer->tags()->attach($ids);

            dd("Přidáno!");
        }else{
            dd("Nepřidáno!");
        }
    }
    public function getEditOffer($id){
        $offer = Offer::where('uuid',$id)->first();
        if($offer == null){
            abort(404);
        }

        $tags = $offer->tags->map(function($x){
           return $x->name;
        });

        return view("offer/edit_offer",["offer"=>$offer,"tags"=>$tags]);
    }

    private function generateUuid(){
        do{
            $str = Str::random(16);
        }while(Offer::where('uuid',$str)->exists());
        return $str;
    }
}
