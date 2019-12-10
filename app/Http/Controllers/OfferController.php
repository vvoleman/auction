<?php

namespace App\Http\Controllers;

use App\Category;
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
        $c = Category::where("disabled",false)->get();
        $data = [
            "types"=>OfferType::all(),
            "curr"=>[
                "all"=>Currency::all(),
                "selected"=>Auth::user()->country->currency
            ],
            "deliveries"=>$d,
            "payments"=>$payments,
            "categories"=>$c
        ];
        return view('offer/new_offer',$data);
    }
    public function getOffer($id){
        $offer = $this->offer_exists($id);

        if($offer->is_time_active()){
            if($offer->type->name == "Prodej"){
                $timestamp = Carbon::parse($offer->end_date);
                $temp = $this->prepareSellData($offer);
                return view("offer/offer_sale",["offer"=>$offer,"timestamp"=>$timestamp]);
            }
        }else{
            if(Auth::user()->id_u = $offer->owner_id){
                return view("offer/renew_offer",["offer"=>$offer]);
            }else{
                return view("offer/expired");
            }
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
            "category_id"=>$data["category"],
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
            $offer->save();

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
            return back()->with("success","Nabídka byla úspěšně prodloužená!");
        }
        return back()->with("danger","Nebylo možné obnovit nabídku!");
    }
    public function deleteOffer(Request $request,$id){
        $offer = Offer::where('uuid',$id)->first();
        if(empty($offer)) return back()->with("danger","Neplatná nabídka!");

        $reason = (empty($request->reason)) ? "-" : $request->reason;

        $offer->delete_reason = $reason;
        $offer->save();
        return redirect()->route("home.home")->with("success","Nabídka byla smazána!");

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
    private function prepareSellData($offer){
        //countryimg
        //regionname
        //deliverylabel
        //paymentlabel
        //price
        //currencyshort
        //end_datetimestamp
        //end_dateformat
        //imgs?
        //tagsname
        //desc
        return [
            "name"=>$offer->name,
            "owner"=>[
                "fullname"=>$offer->owner->fullname,
                "profpic_path"=>$offer->owner->profpic_path(),
                "url"=>route('profile.profile',["uuid"=>$offer->owner->uuid])
            ],
            "is_owner"=>$offer->owner->id_u == Auth::id(),
            "edit_url"=>($offer->owner->id_u == Auth::id()) ? $route('offers.edit',["id"=>$offer->uuid]) : null,
            "price"=>$offer->price,
            
        ];
    }
}
