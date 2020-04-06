<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helpthread extends Model
{
    protected $primaryKey = "id_ht";
    protected $guarded = ["id_ht"];
    public $timestamps = false;
    protected $dates = ["created_at"];

    public function answers(){
        return $this->hasMany("\App\Helpanswer","thread_id");
    }

    public function author(){
        return $this->belongsTo("\App\User","author_id");
    }
}
