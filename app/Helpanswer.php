<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helpanswer extends Model
{
    protected $primaryKey = "id_ha";
    protected $guarded = ["id_ha"];
    public $timestamps = false;
    protected $dates = ["created_at"];

    public function thread(){
        return $this->belongsTo("\App\Helpthread","thread_id");
    }

    public function author(){
        return $this->belongsTo("\App\User","author_id");
    }
}
