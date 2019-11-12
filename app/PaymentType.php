<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $table = "payment_types";
    protected $primaryKey = "id_pt";
    public $timestamps = false;

    public function specific_delivery_type(){
        return $this->belongsTo("\App\DeliveryType","delivery_type_id");
    }
}
