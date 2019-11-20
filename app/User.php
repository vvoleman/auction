<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['firstname','surname', 'email', 'password','activation_token','region_id','uuid','zipcode','address'];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];
    protected $dates = ['last_logged'];
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
    public function current_picture(){
        return $this->belongsTo("\App\Picture","picture_id");
    }
    public function all_pictures(){
        return $this->hasMany("\App\Picture","creator_id");
    }
    public function old_profile_pictures(){
        return $this->all_pictures()->where('id_p','!=',($this->current_picture) ? $this->current_picture->id_p : null)->where('type_id',1);
    }
    public function profpic_path(){
        return ($this->current_picture != null) ? $this->current_picture->path : asset("storage/images/profile_pictures/default.jpg");
    }
    public function getFullnameAttribute(){
        return $this->firstname." ".$this->surname;
    }
    public function offers(){
        return $this->hasMany("\App\Offer","owner_id");
    }
    public function review_score(){
        return 5;
    }
}
