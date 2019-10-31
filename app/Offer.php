<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $primaryKey = "id_o";
    protected $fillable = ["name","price","description","end_date","owner_id","type_id"];

    public function type(){
        return $this->belongsTo("App\OfferType","type_id");
    }
}
