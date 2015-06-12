<?php

namespace App\Modules\Inventory\Models;

class Box extends \Eloquent  
{
	protected $table = 'boxes';
	public  $timestamps = true;

	public function relations()
	{
		return $this->belongsTo('App\Modules\Inventory\Models\Relation');
	}

}