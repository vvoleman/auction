<?php

namespace App\Http\Controllers;

use App\Currency;
use App\DeliveryType;
use App\Offer;
use App\Custom\Translator;
use App\Http\Requests\NewOffer;
use App\Http\Requests\EditOffer;
use App\OfferType;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function getNewOffer(){
        $d = DeliveryType::all();
        $payments = $this->format_deliveries($d);
        $data = [
            "types"=>OfferType::all(),
            "curr"=>[
                "all"=>Currency::all(),
                "selected"=>Auth::user()->country->currency
            ],
            "deliveries"=>$d,
            "payments"=>$payments
        ];
        return view('offer/new_offer',$data);
    }
    public function getOffer($id){
        $offer = $this->offer_exists($id);

        if($offer->type->name == "Prodej"){
            $timestamp = Carbon::parse($offer->end_date);
            return view("offer/offer_sale",["offer"=>$offer,"timestamp"=>$timestamp]);
        }
    }
    public function postNewOffer(NewOffer $request){
        $data = $request->validated();
        $ids = $this->tags_to_array($data["_tags"]);
        $data["end_date"] = Carbon::parse($data["end_date"]);
        if(!$this->correct_payment($data["delivery"],$data["payment"])){
            return back()->with("danger","Neplatné údaje!")->withInput($data);
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
            "owner_id"=>Auth::user()->id_u,
            "delivery_type_id"=>$data["delivery"],
            "payment_type_id"=>$data["payment"]
        ]);
        if($offer->save()){
            $offer->tags()->attach($ids);

            return redirect()->route('offers.offer',["id"=>$uuid])->with("Nabídka úspěšně přidána!");
        }else{
            return back()->with("Nebylo možné přidat nabídku")->withInput($data);
        }
    }
    public function getEditOffer($id){
        $offer = $this->offer_exists($id);

        if(!$offer->is_time_active()){
            return view("offer/renew_offer",["offer"=>$offer]);
        }

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
            $offer->name = $data["name"];
            $offer->description = $data["description"];
            $offer->save();
            $offer->tags()->sync($ids);
            dd($offer);

            return redirect()->route('offers.offer',["id"=>$id])->with("success","Nabídka byla úspěšně upravena!");
        }catch(\Exception $e){
            return redirect()->route('offers.edit',["id"=>$id])->with("danger","Nebylo možné upravit nabídku!");
        }


    }
    public function postRenew($id){
        $offer = $this->offer_exists($id);
        if($offer->is_time_active()){
            return back()->with("danger","Tato nabídka je již aktivní!");
        }
        $offer->end_date = Carbon::now()->addDays(30);
        if($offer->save()){
            return redirect()->route("offers.edit",["id"=>$id])->with("success","Nabídka byla úspěšně prodloužená!");
        }
        return back()->with("danger","Nebylo možné obnovit nabídku!");
    }

    private function generateUuid(){
        do{
            $str = Str::random(16);
        }while(Offer::where('uuid',$str)->exists());
        return $str;
    }
    private function tags_to_array($str){
        $tags = json_decode($str);
        if(empty($tags)) $tags = [];
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
    private function format_deliveries($del){
        $final = [];
        foreach($del as $d){
            $temp = [
                "id"=>$d->id_dt,
                "name"=>$d->label,
                "payments"=>collect($d->all_available_payments())->map(function ($x){
                    return [
                        "id"=>$x->id_pt,
                        "name"=>$x->label
                    ];
                })
            ];
            $final[] = $temp;
        }
        return collect($final);
    }
    private function correct_payment($delivery,$payment){
        $dt = DeliveryType::find($delivery)->all_available_payments();
        foreach($dt as $d){
            if($d->id_pt == $payment){
                return true;
            }
        }
        return false;

    }
}
