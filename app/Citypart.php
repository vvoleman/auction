<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citypart extends Model
{
    protected $primaryKey = "id";
    protected $fillable = ["id","name"];

    public function city(){
    	return $this->belongsTo("\App\City","city_id");
    }
    public function streets(){
    	return $this->hasMany("\App\Street","citypart_id");
    }
}
