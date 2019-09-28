<?php


namespace App\Custom\VerifyRules\Login;


use App\Custom\VerifyRules\IRule;
use App\Custom\VerifyRules\Login\AbstractRule;
use App\User;

class IsAccountVerified implements IRule
{
    private static $error_message = "Váš e-mail není ověřen!";

    public static function check($obj){
        if(!($obj instanceof User)){
            throw new \Exception("Invalid parameter type");
        }

        $res = $obj->email_verified_at != null;
        return ["value"=>$res,"message"=>((!$res) ? self::$error_message : "")];
    }

}
