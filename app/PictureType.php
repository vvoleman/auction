<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PictureType extends Model
{
    protected $primaryKey = "id_pt";
    protected $table = "picture_types";
    public $timestamps = false;


}
