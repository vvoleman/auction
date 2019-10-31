<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
	protected $fillable = ["id","name"];
	protected $primaryKey = "id";

	public function citypart(){
		return $this->belongsTo("\App\Citypart","citypart_id");
	}
}
