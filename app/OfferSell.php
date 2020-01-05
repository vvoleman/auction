<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferSell extends Model
{
    protected $primaryKey = "id_os";
    protected $table = "offer_sells";
    protected $guarded = ["id_os"];
    protected $dates = ["confirmed_at","deleted_at","received_at","created_at"];
    public $timestamps = false;

    public function isConfirmed(){
        return ($this->confirmed_at != null);
    }
    public function buyer(){
        return $this->belongsTo("\App\User","buyer_id");
    }
    public function offer(){
        return $this->belongsTo("\App\Offer","offer_id");
    }

}
