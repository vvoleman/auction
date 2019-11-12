<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Offer;
use App\Custom\Translator;
use App\Http\Requests\NewOffer;
use App\Http\Requests\EditOffer;
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
    public function getOffer($id){

    }
    public function postNewOffer(NewOffer $request,$id){
        $data = $request->validated();
        $ids = $this->tags_to_array($data["_tags"]);
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
        $offer = $this->offer_exists($id);

        $tags = $offer->tags->map(function($x){
           return $x->name;
        });

        return view("offer/edit_offer",["offer"=>$offer,"tags"=>$tags]);
    }
    public function postEditOffer(EditOffer $request,$id){
        $data = $request->validated();
        $offer = $this->offer_exists($id);
        $ids = $this->tags_to_array($data["_tags"]);

        try{
            $offer->update([
                "name"=>$data["name"],
                "description"=>$data["description"],
            ]);
            $offer->tags()->sync($ids);

            return 
        }catch(\Exception $e){
            return redirect()->route('offers.edit',["id"=>$id])->with("danger"=>"Nebylo možné upravit nabídku!");
        }
        

    }

    private function generateUuid(){
        do{
            $str = Str::random(16);
        }while(Offer::where('uuid',$str)->exists());
        return $str;
    }
    private function tags_to_array($str){
        $tags = json_decode($str);
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
        return $ids;
    }
    private function offer_exists($id){
        $offer = Offer::where('uuid',$id)->first();
        if($offer == null){
            abort(404);
        }
        return $offer;
    }
}
