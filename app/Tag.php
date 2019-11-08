<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $primaryKey = "id_t";
    protected $fillable = ["name"];
    public $timestamps = false;

    public function offers(){
    	return $this->belongsToMany("\App\Offer","off_tag","tag_id","offer_id");
    }
}
