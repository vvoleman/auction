<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $primaryKey = "id_nt";
    protected $guarded = ["id_nt"];
    public $timestamps = false;

    public function notifications(){
        return $this->hasMany("\App\Notification","type_id");
    }
    public function priority(){
        return $this->hasMany("\App\Priority","priority_id");
    }
}
