<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = "id_m";
    public $timestamps = false;
    protected $dates = ["seen_at","sent_at"];
    protected $guarded = ["id_m"];

    public function conversation(){
        return $this->belongsTo("\App\Conversation","conversation_id");
    }
    public function from_user(){
        return $this->belongsTo("\App\User","from");
    }
    public function to_user(){
        return $this->belongsTo("\App\User","to");
    }
    public function offersell(){
        return $this->belongsTo("\App\OfferSell","offersell_id");
    }
}
