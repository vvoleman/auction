<?php

namespace App\Http\Controllers;

use App\Country;
use App\Offer;
use App\Currency;
use App\OfferType;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function getSearch(){
        $data = [
            "boot"=>route('ajax.searchBootInfo'),
            "offers"=>route('ajax.searchOffers'),
        ];
        return view("search/search",["urls"=>collect($data),"boot"=>$this->ajaxGetBoot()]);
    }
    public function ajaxGetBoot(){
        $regions = Region::orderBy("name","ASC")->get();
        $temp=[];
        foreach($regions as $r){
            $temp[$r->country->id_c][] = [
                "id"=>$r->id_r,
                "name"=>$r->name
            ];
        }

        $data = [
            "min"=>Offer::min("price"),
            "max"=>Offer::max("price"),
            "types"=>OfferType::select("id_ot as id","name")->get(),
            "currencies"=>Currency::select("id_c as id","name")->get(),
            "countries"=>Country::select("id_c as id","name")->get(),
            "regions"=>$temp
        ];
        return collect($data);
    }
    public function ajaxGetOffers(Request $request){
        $data = $request->validate([
            "price"=>"nullable|array",
            "type"=>"nullable|sometimes|exists:offer_types,id_ot",
            "currency"=>"nullable|sometimes|exists:currencies,id_c",
            "country"=>"nullable|sometimes|exists:countries,id_c",
            "region"=>"nullable|sometimes|exists:regions,id_r",
            "query"=>"nullable|string",
            "order_by"=>"required|string",
            "dir"=>"required|boolean",
            "page"=>"required|integer",
        ]);
        $limit = 5;
        $q = $this->buildQuery($data);
        $count = $q->count();
        $offers = $q->whereDate('end_date','>=',Carbon::now())->skip($data["page"]*$limit)->take($limit)->get();
        $objs = [];
        foreach($offers as $o){
            $objs[] = Offer::find($o->id_o);
        }

        $results = [];
            foreach($objs as $o){
                $results[] = [
                    "id"=>$o->id_o,
                    "name"=>$o->name,
                    "type"=>$o->type->name,
                    "picture"=>(sizeof($o->pictures) > 0) ? $o->pictures[0]->path : null,
                    "price"=>$o->price,
                    "delivery"=>$o->delivery_type->label,
                    "payment"=>$o->payment_type->label,
                    "end_date"=>$o->end_date->format("d. m. Y"),
                    "currency"=>$o->currency->short,
                    "owner"=>[
                        "id"=>$o->owner->id_u,
                        "name"=>$o->owner->fullname,
                        "score"=>$o->owner->review_score(),
                        "picture"=>$o->owner->profpic_path(),
                        "url"=>route('profile.profile',["uuid"=>$o->owner->uuid])
                    ],
                    "url"=>route('offers.offer',["id"=>$o->uuid])
                ];
            }
        return [
            "data"=>$results,
            "next_page"=>(($count-(1+$data["page"])*$limit) > 0) ? $data["page"]+1 : false
        ];
    }

    private function is_set($data,$index){
        return (isset($data[$index])) ? $data[$index] : null;
    }
    private function buildQuery($data){
        $q = Offer::query();
        $q->join("users","offers.owner_id","=","users.id_u")
            ->join("regions","users.region_id","=","regions.id_r");
        if(isset($data["price"])) $q->whereBetween("price",$data["price"]);
        if(isset($data["type"])) $q->where("type_id",$data["type"]);
        if(isset($data["currency"])) $q->where("offers.currency_id",$data["currency"]);
        if(isset($data["country"])) $q->where("regions.country_id",$data["country"]);
        if(isset($data["region"])) $q->where("regions.id_r",$data["region"]);
        return $q;
    }
}
