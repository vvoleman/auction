<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;

class OfferSellController extends Controller
{
    public function getSells($id){
        $offer = Offer::where('uuid',$id)->firstOrFail();
        dd($offer);
    }

    public function ajaxCreateSell(){
        //check if there is no existing active sell for offer

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
}
