<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = "id_m";
    protected $timestamps = false;
    protected $guarded = ["id_m"];

    public function conversation(){
        return $this->belongsTo("\App\Conversation","conversation_id");
    }
    public function from(){
        return $this->belongsTo("\App\User","from");
    }
    public function to(){
        return $this->belongsTo("\App\User","to");
    }
    public function offer(){
        return $this->belongsTo("\App\Offer","offer_id");
    }
}
