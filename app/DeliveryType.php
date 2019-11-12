<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PaymentType;

class DeliveryType extends Model
{
    protected $table = "delivery_types";
    protected $primaryKey = "id_dt";
    public $timestamps = false;

    public function offers(){
        return $this->hasMany("\App\Offer","delivery_type_id");
    }
    public function specific_payment_types(){
        return $this->hasMany("\App\PaymentType","delivery_type_id");
    }
    public function all_available_payments(){
        $p = $this->specific_payment_types;
        $empty = PaymentType::where('delivery_type_id',null)->get();
        return $p->merge($empty)->all();
    }
}
