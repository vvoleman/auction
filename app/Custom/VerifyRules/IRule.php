<?php


namespace App\Custom\VerifyRules;


interface IRule
{
    public static function check($obj);
}
