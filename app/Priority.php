<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $primaryKey = "id_p";
    protected $guarded = ["id_p"];
    public $timestamps = false;

    public function notification_types(){
        return $this->hasMany("\App\NotificationType","priority_id");
    }
}
