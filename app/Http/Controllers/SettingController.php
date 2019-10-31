<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostSetting;
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
            "countries"=>Country::all(),
            "zipcode"=>$user->zipcode,
            "address"=>$user->address
        ];
        //dd(json_encode($data["regions"],JSON_UNESCAPED_UNICODE));
//        /dd($data["countries"]);

        return view("setting/setting",$data);
    }
    public function postSetting(PostSetting $request){
        $data = $request->validated();
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
