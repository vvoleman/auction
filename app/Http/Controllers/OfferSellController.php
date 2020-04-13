<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\OfferSell;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Offer;
use Illuminate\Support\Facades\Auth;

class OfferSellController extends Controller
{
    public function getSells($id){
        $offer = Offer::where('uuid',$id)->firstOrFail();
        $this->canAccess($offer);
        $sells = $offer->sells()->whereNull('deleted_at')->get();
        //fullname, created_at [timestamp], score, flag, region, country
        $sells = $sells->map(function($x)use($id){
            return [
                "fullname"=>$x->buyer->fullname,
                "created_at"=>$x->created_at->timestamp,
                "score"=>$x->buyer->review_score(),
                "flag_img"=>$x->buyer->country->img,
                "region"=>$x->buyer->region->name,
                "url"=>route('offers.confirm',["id"=>$id,"os_id"=>$x->id_os])
            ];
        });
        $sold = ($offer->sold_to_sell != null) ? $offer->sold_to_sell : false;

        return view('offer/confirm_offer_list',["sold"=>$sold,"sells"=>$sells]);
    }
    public function getConfirmOffer($id, OfferSell $os_id){
        $offer = Offer::where('uuid',$os_id->offer->uuid)->firstOrFail();
        $this->canAccess($offer);
        return view('offer/confirm_offer',["os"=>$os_id]);
    }
    public function postConfirmOffer($id,$id_os){
        $os = $this->checkcheck($id,$id_os);
        if(!$os){
            return redirect()->route('offers.confirm',["id"=>$id,"os_id"=>$id_os])->with("danger","Neplatné údaje!");
        }
        $os->confirmed_at = Carbon::now();
        $os->save();
        $os->offer->sold_to = $id_os;
        $os->offer->save();
        event(new NewNotification($os->buyer,[
            "type_id"=>2,
            "notification"=>"Žádost o koupi '".$os->offer->name."' byla přijata",
            "url"=>""
        ]));
        return redirect()->route('home.home')->with("success","Žádost potvrzena!");
    }
    public function postDenyOffer($id,$id_os){
        $os = $this->checkcheck($id,$id_os);
        if(!$os){
            return redirect()->route('offers.confirm',["id"=>$id,"os_id"=>$id_os])->with("danger","Neplatné údaje!");
        }
        $os->denied_at = Carbon::now();
        $os->save();
        event(new NewNotification($os->buyer,[
            "type_id"=>2,
            "notification"=>"Žádost o koupi '".$os->offer->name."' byla zamítnuta!",
            "url"=>""
        ]));
        return redirect()->route('home.home')->with("success","Žádost zamítnuta!");
    }

    private function canCreateSell($offer_id){
        $offer = $this->offerExists($offer_id);
        $available = $offer->availableSell();
        return !$offer || $this->isSold($offer) || !$available || $available == null;
    }
    private function offerExists($offer_id){
        $temp = Offer::find($offer_id);
        return ($temp == null) ? false : $temp;
    }
    private function isSold($offer){
        return $offer->sold_to != null;
    }
    private function checkcheck($id,$id_os){
        $offer = Offer::where('uuid',$id)->first();
        $os = OfferSell::where('id_os',$id_os)->first();
        if($offer == null || $os == null){
            return false;
        }
        return $os;
    }
    private function canAccess($offer){
        if($offer->owner->id_u != Auth::id()){
            abort(403);
        }
    }
}
