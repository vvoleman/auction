<?php
namespace App\Custom;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Uuidable
{
    protected function generateUUID($table)
    {
        do {
            $str = Str::random(8);
        } while (DB::table($table)->where("uuid", $str)->exists());
        return $str;
    }

}

?>
