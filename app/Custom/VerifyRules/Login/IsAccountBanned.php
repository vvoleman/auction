<?php


namespace App\Custom\VerifyRules\Login;


use App\Custom\VerifyRules\IRule;
use App\User;

class IsAccountBanned implements IRule{

    public static function check($obj){
        if(!($obj instanceof User)){
            throw new \Exception("Invalid parameter type");
        }

    }
}
