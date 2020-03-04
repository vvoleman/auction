<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = "id_n";
    protected $guarded = ["id_n"];
    public $timestamps = false;
    protected $dates = ["created_at"];

    public function type(){
        return $this->belongsTo("\App\NotificationType","type_id");
    }
    public function users(){
        return $this->belongsToMany("\App\User","not_use","notification_id","user_id")->withPivot("seen_at");
    }
}
