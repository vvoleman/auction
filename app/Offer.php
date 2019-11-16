<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $primaryKey = "id_o";
    protected $guarded = [];
    protected $dates = ["end_date"];

    public function type(){
        return $this->belongsTo("App\OfferType","type_id");
    }
    public function owner(){
        return $this->belongsTo("\App\User","owner_id");
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
    public function is_time_active(){
        return Carbon::parse($this->end_date)->isFuture();
    }
    public function getDescAttribute(){
        return clean($this->description);
    }
}
