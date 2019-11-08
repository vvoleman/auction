<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Offer;
use App\Custom\Translator;
use App\Http\Requests\NewOffer;
use App\OfferType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function getNewOffer(){
        $t = new Translator();
        $t->translate("ahoj světe");
        return;
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

        foreach($tags as $t){
            $modified = strtolower($t);
        }
        dd($tags);
    }
}
