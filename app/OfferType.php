<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferType extends Model
{
    protected $table = "offer_types";
    protected $primaryKey = "id_ot";

    public function offers(){
        return $this->hasMany("App\Offer","type_id");
    }
}
