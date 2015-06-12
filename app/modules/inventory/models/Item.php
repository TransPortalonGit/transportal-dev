<?php

namespace App\Modules\Inventory\Models;

class Item extends \Eloquent  
{

	protected $table = 'items';

	public  $timestamps = true;

	public function relations()
	{
		return $this->belongsTo('App\Modules\Inventory\Models\Relation');
	}

}