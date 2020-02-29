<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;

class Conversation extends Model
{
    use EagerLoadPivotTrait;

    protected $primaryKey = "id_c";
    protected $guarded = ["id_c"];
    public $timestamps = false;
    protected $dates = ["created_at","updated_at"];

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
