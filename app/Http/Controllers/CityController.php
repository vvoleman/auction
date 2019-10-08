<?php

namespace App\Http\Controllers;

use App\Region;
use App\Regpart;
use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCity(){
        $reg = $this->regions();
        $regparts = [];
        foreach ($reg as $r){
            $regparts = array_merge($regparts,$this->regparts($r["id"]));
        }
        die(json_encode($regparts,JSON_UNESCAPED_UNICODE));

    }
    private function regions(){
        $url = "https://b2c.cpost.cz/services/Address/getRegionListAsJson";
        return array_map(function($x){
            $x["id"] = intval($x["id"]);
            return $x;
        },json_decode(file_get_contents($url, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false)))),true));
    }
    private function regparts($id){
        return array_map(function($x){
            $x["id"] = intval($x["id"]);
            return $x;
        },json_decode(file_get_contents( "https://b2c.cpost.cz/services/Address/getDistrictListAsJson?id=".$id, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false)))),true));
    }
    private function cities($id){
        return array_map(function($x){
            $x["id"] = intval($x["id"]);
            return $x;
        },json_decode(file_get_contents( "https://b2c.cpost.cz/services/Address/getCityListAsJson?id=".$id, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false)))),true));
    }
    private function get($url){
        return json_decode(file_get_contents($url, false, stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false)))),true);
    }
    private function run($run){
        $run = intval($run);
        $limit = 5;
        echo ($limit*$run+1).",".(($run+1)*$limit);
        $regions = Regpart::whereBetween('id',[$limit*$run+1,($run+1)*$limit])->get();
        foreach($regions as $r){
            $regparts = $this->cities($r->id);
            foreach($regparts as $rp){
                $rp["regpart_id"] = $r->id;
                City::create($rp);
            }
        }
        echo "<br>";
        echo "<a href='".route('city',["run"=>$run+1])."'>zde</a>";
    }
}
