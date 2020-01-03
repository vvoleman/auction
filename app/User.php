<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $hidden = ['password', 'remember_token',];
    protected $guarded = ['id_u'];
    protected $casts = ['email_verified_at' => 'datetime',];
    protected $dates = ['last_logged'];
    protected $primaryKey = 'id_u';

    //relationships
    public function group(){
        return $this->belongsTo("App\Group","group_id");
    }
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
    public function offers(){
        return $this->hasMany("\App\Offer","owner_id");
    }
    public function all_pictures(){
        return $this->hasMany("\App\Picture","creator_id");
    }
    public function notifications(){
        return $this->belongsToMany("\App\Notification","not_use","user_id","notification_id")->withPivot("seen_at");
    }

    //methods
    public function hasPermission($permission){
        $data = $this->group->all_perms()->filter(function ($x) use($permission){
            return $x->permission == $permission;
        });
        return $data->count() > 0;
    } //nutno dodělat
    public function old_profile_pictures(){
        return $this->all_pictures()->where('id_p','!=',($this->current_picture) ? $this->current_picture->id_p : null)->where('type_id',1);
    }
    public function profpic_path(){
        return ($this->current_picture != null) ? $this->current_picture->path : asset("storage/images/profile_pictures/default.jpg");
    }
    public function getFullnameAttribute(){
        return $this->firstname." ".$this->surname;
    }
    public function getFulladdressAttribute(){
        //Kollárova 226/2, 400 03 Ústí nad Labem
        return $this->address.", ".$this->zipcode." ".$this->city;
    }
    public function review_score(){
        return 5;
    }
}
