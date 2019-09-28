<?php
namespace App\Custom\VerifyRules\Login;

use App\Custom\VerifyRules\IRule;
use Illuminate\Support\Facades\Hash;

class AreCredentialsCorrect implements IRule {

        private static $error_message = "Neplatné přihlašovací údaje!";

        public static function check($obj){
            if(gettype($obj) != "array" || !array_key_exists("email",$obj) || !array_key_exists("password",$obj)){
                throw new \Exception("Invalid parameter type!");
            }

            $user = User::where("email",$obj["email"])->first();
            $res = $user != null && Hash::check($obj["password"],$user->password);

            return ["value"=>$res,"message"=>((!$res) ? static::$error_message : "")];
        }

    }
?>
