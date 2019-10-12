<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['firstname','surname', 'email', 'password','activation_token','region_id'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];
    protected $primaryKey = 'id_u';

    public function group(){
        return $this->belongsTo("App\Group","group_id");
    }
    public function hasPermission($permission){
        dd($permission);
    } //nutno dodělat
    public function country(){
        return $this->hasOneThrough(
            'App\Country',
            'App\Region',
            'id_r',
            'id_c',
            'region_id',
            'country_id'
        );
    }
    public function region(){
        return $this->belongsTo("\App\Region","region_id");
    }
}
