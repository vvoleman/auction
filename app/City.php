<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "cities";
    protected $primaryKey = "id_c";
    public $timestamps = false;
    protected $fillable = ["id","name","regpart_id"];

    public function regpart(){
        return $this->belongsTo("\App\Regpart","regpart_id");
    }
    public function region(){
        return $this->regpart->region();
    }

}
