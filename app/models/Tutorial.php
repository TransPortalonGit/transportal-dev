<?php

class Tutorial extends Eloquent {

	protected $table = 'tutorials';

	public  $timestamps = true;
	
	public function user()
    {
        return $this->belongsTo('User');
    }	

}