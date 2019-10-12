<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = "regions";
    protected $primaryKey = "id_r";
    public $timestamps = false;
    protected $fillable = ["id","name"];

    public function country(){
        return $this->belongsTo("\App\Country","country_id");
    }
}
