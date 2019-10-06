<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regpart extends Model
{
    protected $table = "regparts";
    public $timestamps = false;
    protected $fillable = ["id","name","region_id"];

    public function cities(){
        return $this->hasMany("\App\City","regpart_id");
    }
    public function region(){
        return $this->belongsTo("\App\Region","region_id");
    }
}
