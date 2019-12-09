<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $primaryKey = "id_o";
    protected $guarded = ["id_o"];
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
    public function pictures(){
        return $this->belongsToMany("\App\Picture","off_pic","offer_id","picture_id")->withPivot("deleted_at");
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
    public function category(){
        return $this->belongsTo("\App\Category","category_id");
    }
    public function sells(){
        return $this->hasMany("\App\OfferSell","offer_id");
    }
    public function availableSell(){
        if($this->sold_to != null){
            return false;
        }
        return $this->sells()->whereNull('deleted_at')->first();
    }

    public function isActive(){
        return !$this->end_date->isPast();
    }
    public function is_time_active(){
        return Carbon::parse($this->end_date)->isFuture();
    }
    public function getDescAttribute(){
        return clean($this->description);
    }
}
