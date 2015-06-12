<?php

namespace App\Modules\Inventory\Models;

class Surface extends \Eloquent  
{
	public  $timestamps = true;

	public function relations()
	{
		return $this->belongsTo('App\Modules\Inventory\Models\Relation');
	}

}