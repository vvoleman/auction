<?php

namespace App\Http\Controllers;

use App\Region;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class SettingController extends Controller
{
    public function getSetting(){
        $user = Auth::user();
        $regions = [
            "short"=>$user->country->short,
            "regions"=>array_map(function($r){return ["id"=>$r["id_r"],"name"=>$r["name"]];},$user->country->regions->toArray())
        ];
        $data = [
            "email"=>$user->email,
            "firstname"=>$user->firstname,
            "surname"=>$user->surname,
            "country_id"=>$user->country->id_c,
            "region_id"=>$user->region_id,
            "regions"=>new Collection($regions),
            "countries"=>Country::all()
        ];
        //dd(json_encode($data["regions"],JSON_UNESCAPED_UNICODE));
//        /dd($data["countries"]);

        return view("setting/setting",$data);
    }
    public function postSetting(Request $request){
        $data = $request->validate([
            "firstname"=>"required|min:2|max:32",
            "surname"=>"required|min:2|max:64",
            "region_id"=>"required|exists:regions,id_r"
        ],[
            "firstname.required"=>"Jméno musí být vyplněno",
            "firstname.min"=>"Minimální délka jména jsou 2 znaky",
            "firstname.max"=>"Maximální délka jména je 64 znaků",
            "surname.required"=>"Příjmení musí být vyplněno",
            "surname.min"=>"Minimální délka příjmení jsou 2 znaky",
            "surname.max"=>"Maximální délka příjmení je 64 znaků",
            "region_id.required"=>"Chybějící údaj (kraj)",
            "region_id.exists"=>"Neplatný údaj (kraj)"
        ]);

        $user = Auth::user();
        $data["region_id"] = intval($data["region_id"]);
        if($user->update($data)){
            $err = "success";
            $msg = "Údaje byly úspěšně upraveny!";
        }else{
            $err = "danger";
            $msg = "Nebylo možné upravit údaje";
        }
        return redirect()->route('setting.setting')->with($err,$msg);
    }

    public function ajaxGetRegionsByCountry(Request $request){
        $data = $request->validate([
            "id"=>"required|exists:countries,short"
        ]);

        $regions = Country::where('short',$data["id"])->first()->regions;
        return $regions->map(function($r){
            return ["id"=>$r->id_r,"name"=>$r->name];
        });
    }
}
