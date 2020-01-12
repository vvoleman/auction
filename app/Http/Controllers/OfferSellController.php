<?php

namespace App\Http\Controllers;

use App\OfferSell;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Offer;

class OfferSellController extends Controller
{
    public function getSells($id){
        $offer = Offer::where('uuid',$id)->firstOrFail();
        dd($offer);
    }
    public function getConfirmOffer($id, OfferSell $os_id){
        $offer = Offer::where('uuid',$id)->firstOrFail();
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
        return redirect()->route('home.home')->with("success","Žádost potvrzena!");
    }
    public function postDenyOffer($id, OfferSell $id_os){

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
}
