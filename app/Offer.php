<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $primaryKey = "id_o";
    protected $fillable = ["uuid","name","price","description","end_date","owner_id","type_id","currency_id"];
    public $timestamps = false;

    public function type(){
        return $this->belongsTo("App\OfferType","type_id");
    }
    public function currency(){
    	return $this->belongsTo("\App\Currency","currency_id");
    }
    public function isActive(){
    	return !$this->end_date->isPast();
    }
    public function tags(){
    	return $this->belongsToMany("\App\Tag","off_tag","offer_id","tag_id");
    }
}
