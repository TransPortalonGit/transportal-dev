<?php

class Items_user extends Eloquent  
{

	protected $table = 'items_users';

	public  $timestamps = true;

	public function user()
    {
        return $this->belongsTo('User');
    }	

}