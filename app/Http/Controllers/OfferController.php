<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Http\Requests\NewOffer;
use App\OfferType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        dd($request->validated());
    }
}
