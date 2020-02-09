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


    public function isDeleted(){
        return ($this->deleted_at != null);
    }
    public function isConfirmed(){
        return ($this->confirmed_at != null);
    }
    public function isDenied(){
        return ($this->denied_at != null);
    }
    public function isFinished(){
        return ($this->received_at != null);
    }
    public function getStatus(){
        if($this->isDeleted() != null){
            return "deleted";
        }
        if($this->isDenied()){
            return "denied";
        }
        if($this->isConfirmed()){
            return "confirmed";
        }
        if($this->isFinished()){
            return "finished";
        }

        return "waiting";
    }

    public function buyer(){
        return $this->belongsTo("\App\User","buyer_id");
    }
    public function offer(){
        return $this->belongsTo("\App\Offer","offer_id");
    }

}
