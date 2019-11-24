<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = "id_c";
    protected $guarded = ["id_c"];

    public function offers(){
        return $this->hasMany("\App\Offer","category_id");
    }
    public function picture(){
        return $this->belongsTo("\App\Picture","picture_id");
    }
}
