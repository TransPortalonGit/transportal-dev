<?php

namespace App\Modules\Inventory\Models;

class Room extends \Eloquent  
{
	public  $timestamps = true;

	public function relations()
	{
		return $this->belongsTo('App\Modules\Inventory\Models\Relation');
	}

}