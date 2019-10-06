<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = "regions";
    protected $primaryKey = "id_r";
    public $timestamps = false;
    protected $fillable = ["id","name"];

    public function regparts(){
        return $this->hasMany("\App\Regpart","region_id");
    }
    public function cities(){
        return $this->hasManyThrough("\App\City","\App\RegPart","region_id","regpart_id","id","id");
    }
}
