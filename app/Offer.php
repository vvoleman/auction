<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $primaryKey = "id_o";
    protected $guarded = [];

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
    public function delivery_type(){
        return $this->belongsTo("\App\DeliveryType","delivery_type_id");
    }
    public function payment_type(){
        return $this->belongsTo("\App\PaymentType","payment_type_id");
    }
}
