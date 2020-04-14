<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OfferSell extends Model
{
    protected $primaryKey = "id_os";
    protected $table = "offer_sells";
    protected $guarded = ["id_os"];
    protected $dates = ["confirmed_at","deleted_at","received_at","created_at","shipped_at"];
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
    public function isShipping(){
        return ($this->shipped_at != null);
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
        if($this->isFinished()){
            return "finished";
        }
        if($this->isShipping()){
            return "shipped";
        }
        if($this->isConfirmed()){
            return "confirmed";
        }


        return "waiting";
    }
    public function setStatus($status){
        switch ($status){
            case "shipped":
                $this->shipped_at = Carbon::now();
                break;
            case "finished":
                $this->received_at = Carbon::now();
                break;
            default:
                return false;
        }
        return $this->save();
    }
    public function getStatusTimestamp(){
        $format = "d. m. Y H:i";

        if($this->isDeleted() != null){
            return $this->deleted_at->format($format);
        }
        if($this->isDenied()){
            return $this->denied_at->format($format);
        }
        if($this->isFinished()){
            return $this->received_at->format($format);
        }
        if($this->isShipping()){
            return $this->shipped_at->format($format);
        }
        if($this->isConfirmed()){
            return $this->confirmed_at->format($format);
        }
    }
    public function buyer(){
        return $this->belongsTo("\App\User","buyer_id");
    }
    public function offer(){
        return $this->belongsTo("\App\Offer","offer_id");
    }

}
