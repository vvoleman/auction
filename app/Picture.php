<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Picture extends Model
{
    protected $primaryKey = "id_p";
    protected $table = "pictures";
    protected $fillable = ["picture_path","creator_id","type_id"];
    public $timestamps = false;
    protected $dates = ["created_at"];

    public function picture_type(){
        return $this->belongsTo("\App\PictureType","type_id");
    }
    public function creator(){
        return $this->belongsTo("\App\User","creator_id");
    }
    public function getPathAttribute(){
        return asset('storage/images'.$this->picture_path);
    }
}
