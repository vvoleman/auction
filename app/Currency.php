<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table=  "currencies";
    protected $primaryKey = "id_c";

    public function countries(){
        return $this->hasMany("App\Country","currency_id");
    }
    public function offers(){
        return $this->hasMany("App\Offer","currency_id");
    }
}
