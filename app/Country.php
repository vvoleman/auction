<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Country extends Model
{
    protected $primaryKey = "id_c";
    protected $table = "countries";
    public $timestamps = false;

    public function getImgAttribute(){
        return URL::asset("assets/images/countries/flags/".$this->img_path);
    }
    public function regions(){
        return $this->hasMany("\App\Region","country_id");
    }
    public function currency(){
        return $this->belongsTo("App\Currency","currency_id");
    }
}
