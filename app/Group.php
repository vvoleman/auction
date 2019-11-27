<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ["name","created_by"];
    protected $primaryKey = "id_g";

    public function users(){
        return $this->hasMany("App\User","group_id");
    }
    public function permissions(){
        return $this->belongsToMany("App\Permission","gro_per","group_id","perm_id")->withPivot(['deleted_at','added_at','perm_id']);
    }
    public function all_perms(){
        return $this->permissions()->whereNull('deleted_at')->get();
    }
}
