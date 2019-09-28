<?php


namespace App\Custom\VerifyRules;


class Verifier{

    public static function check(array $arr){
        try{
            foreach ($arr as $a){
                if(!$a["value"]){
                    return $a;
                }
            }
        }catch (\Exception $e){
            return ["value"=>false,"message"=>"Při ověřování se vyskytla chyba!"];
        }
        return ["value"=>true,"message"=>""];
    }
}
