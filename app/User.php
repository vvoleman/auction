<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $hidden = ['password', 'remember_token',];
    protected $guarded = ['id_u'];
    protected $casts = ['email_verified_at' => 'datetime',];
    protected $dates = ['last_logged'];
    protected $primaryKey = 'id_u';

    //relationships
    public function group()
    {
        return $this->belongsTo("App\Group", "group_id");
    }
    public function country()
    {
        return $this->hasOneThrough(
            'App\Country',
            'App\Region',
            'id_r',
            'id_c',
            'region_id',
            'country_id'
        );
    }
    public function region()
    {
        return $this->belongsTo("\App\Region", "region_id");
    }
    public function current_picture()
    {
        return $this->belongsTo("\App\Picture", "picture_id");
    }
    public function offers()
    {
        return $this->hasMany("\App\Offer", "owner_id");
    }
    public function notifications()
    {
        return $this->belongsToMany("\App\Notification", "not_use", "user_id", "notification_id")->withPivot("seen_at");
    }
    public function sent_messages(){
        return $this->hasMany("\App\Message","from");
    }
    public function received_messages(){
        return $this->hasMany("\App\Message","to");
    }
    public function conversations(){
        return $this->belongsToMany("\App\Conversation","con_use","user_id","conversation_id");
    }
    public function bought(){
        return $this->hasMany("\App\OfferSell","buyer_id");
    }

    //methods
    public function hasPermission($permission)
    {
        $data = $this->group->all_perms()->filter(function ($x) use ($permission) {
            return $x->permission == $permission;
        });
        return $data->count() > 0;
    }
    public function old_profile_pictures()
    {
        return $this->all_pictures()->where('id_p', '!=', ($this->current_picture) ? $this->current_picture->id_p : null)->where('type_id', 1);
    } //nutno dodělat
    public function all_pictures()
    {
        return $this->hasMany("\App\Picture", "creator_id");
    }
    public function profpic_path()
    {
        return ($this->current_picture != null) ? $this->current_picture->path : asset("storage/images/profile_pictures/default.jpg");
    }
    public function getFullnameAttribute()
    {
        return $this->firstname . " " . $this->surname;
    }
    public function getFulladdressAttribute()
    {
        //Kollárova 226/2, 400 03 Ústí nad Labem
        return $this->address . ", " . $this->zipcode . " " . $this->city;
    }
    public function review_score()
    {
        return 5;
    }
    public function messages_with(User $u,$os_id = null){
        $q = Message::query();
        if($os_id != null){
            $q->where('offersell_id',$os_id);
        }else{
            $q->whereNull('offersell_id');
        }
        $all = $q->where(function($query){
            $query->where('from',$this->id_u)
                ->orWhere('to',$this->id_u);
        })
        ->orWhere(function($query)use($u){
            $query->where('from',$u->id_u)
                ->orWhere('to',$u->id_u);
        })->get();
        return $all;
    }
    public function contacts(){
        $msgs = Message::where('from',$this->id_u)->orWhere('to',$this->id_u);

    }
    public function test(){
        return $this->hasManyThrough("\App\User","\App\Conversation");
    }
    public function conversation_with(User $user){
        if($this->id_u == $user->id_u){
            return false;
        }
        $sql = "SELECT cu.conversation_id FROM users JOIN con_use cu ON cu.user_id = users.id_u WHERE users.id_u = ? AND cu.conversation_id IN (SELECT con_use.conversation_id FROM users JOIN con_use ON con_use.user_id = users.id_u WHERE users.id_u = ?)";
        $temp = User::select('cu.conversation_id as conversation_id')->join('con_use as cu','cu.user_id','=','users.id_u')->where('users.id_u',$this->id_u)->whereIn('cu.conversation_id',function($query)use($user){
           $query->select("con_use.conversation_id")->from('users')->join('con_use','con_use.user_id','=','users.id_u')->where('users.id_u',$user->id_u);
        })->get();
        if(sizeof($temp) == 0){
            return null;
        }
        return Conversation::find($temp[0]["conversation_id"]);
    }
    public function unread_conversations(){
        $convs = [];
        $send = [];
        $msgs = $this->received_messages()->whereNull('offersell_id')->whereNull('seen_at')->get();
        foreach($msgs as $m){
            $convs[$m->conversation->uuid] = $m;
        }
        foreach($convs as $key => $value){
            $send[] = [
                "url"=>route('message.message',["open"=>$key]),
                "conversation_uuid"=>$key,
                "from"=>[
                    "name"=>$value->from_user->fullname,
                    "img"=>$value->from_user->profpic_path()
                ],
                "message"=>[
                    "message"=>$value->message,
                    "send_at"=>$value->sent_at->timestamp
                ]
            ];
        }
        return $send;

    }
}
