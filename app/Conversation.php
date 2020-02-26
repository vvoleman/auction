<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $primaryKey = "id_c";
    protected $guarded = ["id_c"];

    public function users(){
        return $this->belongsToMany("\App\User","con_use","conversation_id","user_id");
    }
    public function messages(){
        return $this->hasMany("\App\Message","conversation_id");
    }
    public function getOppositeUser(User $u){
        return $this->users()->where("user_id","!=",$u->id_u)->first();
    }
}
