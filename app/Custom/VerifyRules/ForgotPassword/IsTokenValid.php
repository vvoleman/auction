<?php
namespace App\Custom\VerifyRules\ForgotPassword;

use App\Custom\VerifyRules\IRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IsTokenValid implements IRule {

    private static $error_message = "Neplatný token!";

    public static function check($obj){
        if(gettype($obj) != "string"){
            throw new \Exception("Invalid parameter type!");
        }
        $res = DB::table('password_resets')->where('token',$obj)->where('created_at',">=",Carbon::now()->subHour())->whereNull('used_at')->exists();
        return ["value"=>$res,"message"=>((!$res) ? static::$error_message : "")];
    }
}
?>
