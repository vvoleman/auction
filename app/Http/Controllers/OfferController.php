<?php

namespace App\Http\Controllers;

use App\Category;
use App\Currency;
use App\DeliveryType;
use App\Events\OfferSellCreated;
use App\Listeners\SendOfferSellNotification;
use App\Offer;
use App\Custom\Translator;
use App\Http\Requests\NewOffer;
use App\Http\Requests\EditOffer;
use App\OfferSell;
use App\OfferType;
use App\Picture;
use App\PictureType;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\NewNotification;

class OfferController extends Controller
{
    public function getNewOffer()
    {
        $d = DeliveryType::all();
        $payments = $this->format_deliveries($d);
        $c = Category::where("disabled", false)->get();
        $data = [
            "types" => OfferType::all(),
            "curr" => [
                "all" => Currency::all(),
                "selected" => Auth::user()->country->currency->id_c
            ],
            "deliveries" => $d,
            "payments" => $payments,
            "categories" => $c
        ];
        return view('offer/new_offer', ["data"=>collect($data)]);
    }
    private function format_deliveries($del)
    {
        $final = [];
        foreach ($del as $d) {
            $temp = [
                "id" => $d->id_dt,
                "name" => $d->label,
                "payments" => collect($d->all_available_payments())->map(function ($x) {
                    return [
                        "id" => $x->id_pt,
                        "name" => $x->label
                    ];
                })
            ];
            $final[] = $temp;
        }
        return collect($final);
    }
    public function getOffer($id)
    {
        $offer = $this->offer_exists($id);

        if ($offer->is_time_active()) {
            if ($offer->type->name == "Prodej") {
                if($offer->sold_to != null && $offer->owner->id_u != Auth::id()){
                    return redirect()->route('home.home')->with("danger","Nabídka již není aktuální!");
                }
                $timestamp = Carbon::parse($offer->end_date);
                $temp = $this->prepareSellData($offer);
                return view("offer/offer_sale", ["offer"=>$offer,"data" => collect($temp)->toJson(JSON_UNESCAPED_UNICODE)]);
            }
        } else {
            if (Auth::user()->id_u == $offer->owner_id) {
                return view("offer/renew_offer", ["offer" => $offer]);
            } else {
                return view("offer/expired");
            }
        }
    }
    public function getEditOffer($id)
    {
        $offer = $this->offer_exists($id);

        if (!$offer->is_time_active()) {
            return view("offer/renew_offer", ["offer" => $offer]);
        }

        $data = [
            "name"=>$offer->name,
            "type"=>$offer->type->name,
            "end_date"=>$offer->end_date->toDateTimeLocalString(),
            "description"=>$offer->description,
            "currency"=>$offer->currency->short,
            "delivery"=>$offer->delivery_type->label,
            "payment"=>$offer->payment_type->label,
            "price"=>$offer->price,
            "tags"=>$offer->tags->map(function ($x) {
                return $x->name;
            }),
        ];

        $tags = $offer->tags->map(function ($x) {
            return $x->name;
        });

        return view("offer/edit_offer", ["data"=>collect($data),"images"=>collect($this->format_pictures($offer)),"offer" => $offer, "tags" => $tags]);
    }
    public function postNewOffer(NewOffer $request)
    {
        $data = $request->validated();
        $ids = $this->tags_to_array($data["_tags"]);
        if (!$this->correct_payment($data["delivery"], $data["payment"])) {
            return back()->with("danger", "Neplatné údaje!")->withInput($data);
        }
        $uuid = $this->generateUuid();
        $offer = new Offer([
            "name" => $data["name"],
            "type_id" => $data["type"],
            "price" => $data["price"],
            "description" => $data["description"],
            "end_date" => Carbon::now()->addDays(30),
            "uuid" => $uuid,
            "category_id" => $data["category"],
            "currency_id" => $data["currency"],
            "owner_id" => Auth::user()->id_u,
            "delivery_type_id" => $data["delivery"],
            "payment_type_id" => $data["payment"]
        ]);
        if ($offer->save()) {
            $offer->tags()->attach($ids);

            $pics = [];
            $creator_id = Auth::id();
            foreach($data["images_upl"] as $p){
                $path = $this->uploadFile(["type_id"=>2,"image"=>$p]);
                if($path != false){
                    $img = Picture::create(["picture_path"=>$path,"creator_id"=>$creator_id,"type_id"=>2]);
                    $pics[] = $img->id_p;
                }
            }
            $offer->pictures()->attach($pics);

            return redirect()->route('offers.offer', ["id" => $uuid])->with("Nabídka úspěšně přidána!");
        } else {
            return back()->with("Nebylo možné přidat nabídku")->withInput($data);
        }
    }
    public function postEditOffer(EditOffer $request, $id)
    {
        $data = $request->validated();
        $offer = $this->offer_exists($id);
        $ids = $this->tags_to_array($data["_tags"]);

        try {
            $offer->name = $data["name"];
            $offer->description = $data["description"];
            $offer->save();
            $offer->tags()->sync($ids);
            $offer->save();

            return redirect()->route('offers.offer', ["id" => $id])->with("success", "Nabídka byla úspěšně upravena!");
        } catch (\Exception $e) {
            return redirect()->route('offers.edit', ["id" => $id])->with("danger", "Nebylo možné upravit nabídku!");
        }
    }
    public function postRenew($id)
    {
        $offer = $this->offer_exists($id);
        if ($offer->is_time_active()) {
            return back()->with("danger", "Tato nabídka je již aktivní!");
        }
        $offer->end_date = Carbon::now()->addDays(30);
        if ($offer->save()) {
            return back()->with("success", "Nabídka byla úspěšně prodloužená!");
        }
        return back()->with("danger", "Nebylo možné obnovit nabídku!");
    }
    public function deleteOffer(Request $request, $id)
    {
        $offer = Offer::where('uuid', $id)->first();
        if (empty($offer)) return back()->with("danger", "Neplatná nabídka!");

        $reason = (empty($request->reason)) ? "-" : $request->reason;

        $offer->delete_reason = $reason;
        $offer->save();
        return redirect()->route("home.home")->with("success", "Nabídka byla smazána!");

    }

    public function ajaxBuyOffer(Request $request)
    {
        $data = $request->validate([
            "offer_id" => "required|exists:offers,uuid",
            "address" => "required|string",
            "name" => "required|string"
        ]);
        //byla by fajn validace adres, ale víme jak to je :--)
        //nechtěl jsem to už koupit?
        $offer = Offer::where('uuid',$data["offer_id"])->first();
        $offer_id = $offer->id_o;
        if (OfferSell::where('offer_id',$offer_id)->where('buyer_id', Auth::id())->whereNull('deleted_at')->exists()) {
            $response = [400,"Žádost o koupi již existuje!"];
        } else {
            $offer = Offer::where("uuid", $data["offer_id"])->first();
            if ($offer->isActive() && $offer->sold_to == null) {
                $os = new OfferSell([
                    "buyer_id" => Auth::id(),
                    "offer_id" => $offer->id_o,
                    "address" => $data["address"],
                    "name" => $data["name"]
                ]);
                if ($os->save()) {
                    $response = [200, "Žádost o koupi byla odeslána!"];
                    event(new OfferSellCreated($os));
                } else {
                    $response = [500, "Nelze vytvořit žádost o koupi!"];
                }
            } else {
                $response = [400, "Nabídka není aktuální!"];
            }
        }
        return response()->json(["message" => $response[1]],$response[0]);
        //je offer aktivní?
        //není prodaná?

        //vytvoř sell

        //vrať odpověď

    }
    public function ajaxRemoveOfferSell(Request $request){
        $data = $request->validate([
            "offer_id"=>"required|exists:offers,uuid"
        ]);
        $user = Auth::user();
        $offer = Offer::where('uuid',$data["offer_id"])->first();
        //je tam nějaká smazatelná nabídka?
        $temp = $offer->sells()->where('buyer_id',$user->id_u)->whereNull('deleted_at')->whereNull('confirmed_at');
        if($temp->exists()){
            if($temp->update(["deleted_at"=>Carbon::now()])){
                $res = ["Žádost o koupi byla úspěšně smazána!",200];
                event(new NewNotification($offer->owner,[
                    "type_id"=>2,
                    "notification"=>"Uživatel stáhl žádost o '".$offer->name."'",
                    "url"=>""
                ]));
            }else{
                $res = ["Nelze smazat žádost o koupi!",500];
            }
        }else{
            $res = ["Nebyla nalezena žádná žádost o koupi!",404];
        }
        return response()->json(["message"=>$res[0]],$res[1]);
    }
    public function ajaxUpdateImages(Request $request){
        $data = $request->validate([
            "uuid"=>"required|exists:offers,uuid",
            "existing"=>"nullable|array",
            "image.*"=>"nullable|mimes:jpeg,png,jpg,gif,svg|max:8192"
        ]);

        $offer = Offer::where('uuid',$data["uuid"])->first();
        $ids = [];
        $uid = Auth::id();
        if(isset($data["existing"])){
            foreach($data["existing"] as $e){
                if(Picture::where('id_p',$e)->where('creator_id',$uid)->exists()) $ids[] = intval($e);
            }
        }
        if(isset($data["image"])){
            foreach($data["image"] as $i){
                $path = $this->uploadFile(["type_id"=>2,"image"=>$i]);
                if($path != false){
                    $pic = Picture::create([
                       "type_id"=>2,
                       "creator_id"=>$uid,
                       "picture_path"=>$path
                    ]);
                    $ids[] = $pic->id_p;
                }else{
                    return response()->json(["message"=>"Obrázky nelze uložit","status"=>500]);
                }
            }
        }

        $offer->pictures()->sync($ids);
        return response()->json(["message"=>"Obrázky byly úspěšně uloženy!","data"=>$this->format_pictures($offer),"status"=>200]);
    }

    private function offer_exists($id)
    {
        $offer = Offer::where('uuid', $id)->first();
        if ($offer == null) {
            abort(404);
        }
        return $offer;
    }
    private function format_pictures($offer){
        return $offer->pictures->map(function($x){return ["url"=>$x->path,"id"=>$x->id_p];});
    }
    private function prepareSellData($offer)
    {
        $timestamp = strtotime($offer->end_date);
        $user = Auth::user();
        return [
            "customer" => [
                "fullname" => $user->fullname,
                "address" => $user->fulladdress,
                "can_buy"=>!OfferSell::where('offer_id',$offer->id_o)->where('buyer_id', Auth::id())->whereNull('deleted_at')->exists()
            ],
            "name" => $offer->name,
            "pictures"=>$offer->safe_pictures(),
            "owner" => [
                "fullname" => $offer->owner->fullname,
                "address"=>$offer->owner->fulladress,
                "profpic_path" => $offer->owner->profpic_path(),
                "url" => route('profile.profile', ["uuid" => $offer->owner->uuid])
            ],
            "is_owner" => $offer->owner->id_u == Auth::id(),
            "edit_url" => ($offer->owner->id_u == Auth::id()) ? route('offers.edit', ["id" => $offer->uuid]) : null,
            "price" => $offer->price,
            "tags" => $offer->tags->map(function ($x) {
                return $x->name;
            }),
            "country_img" => $offer->owner->region->country->img,
            "region" => $offer->owner->region->name,
            "delivery" => $offer->delivery_type->label,
            "payment" => $offer->payment_type->label,
            "currency" => $offer->currency->short,
            "uuid" => $offer->uuid,
            "end_date" => [
                "timestamp" => $timestamp,
                "format" => date("d. m. Y H:i", $timestamp)
            ],
            "description" => $offer->desc,
            "imgs" => [] //TODO
        ];
    }

    private function tags_to_array($str)
    {
        $tags = json_decode($str);
        if (empty($tags)) $tags = [];
        $ids = [];
        foreach ($tags as $t) {
            if (true /*preg_match("/pL/",$t)*/) {
                if (Tag::where('name', $t)->exists()) {
                    $ids[] = Tag::where('name', $t)->first()->id_t;
                } else {
                    $tag = new Tag([
                        "name" => $t
                    ]);
                    $tag->save();
                    $ids[] = $tag->id_t;
                }
            }
        }
        return $ids;
    }
    private function correct_payment($delivery, $payment)
    {
        $dt = DeliveryType::find($delivery)->all_available_payments();
        foreach ($dt as $d) {
            if ($d->id_pt == $payment) {
                return true;
            }
        }
        return false;

    }
    private function generateUuid()
    {
        do {
            $str = Str::random(16);
        } while (Offer::where('uuid', $str)->exists());
        return $str;
    }
    private function uploadFile($data){
        $type = PictureType::find($data["type_id"]);
        $abs = "images/".$type->name."s";
        $ext = $data["image"]->extension();
        do{
            $path = Str::random('32');
        }while(Storage::exists($abs."/".$path.".".$ext));

        $data["image"]->storeAs("public/".$abs,$path.".".$ext);
        return "/".$type->name."s"."/".$path.".".$ext;
    }
}
