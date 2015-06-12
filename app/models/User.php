<?php

class User extends Eloquent
{

    protected $table = 'users';

    public function projects()
    {
        return $this->hasMany('Project');
    }

    public function tutorials()
    {
        return $this->hasMany('Tutorial');
    }

    public function items_users()
    {
        return $this->hasMany('Items_user');
    }

    public function listings()
    {
        return $this->hasMany('Listing');
    }

    public function questions()
    {
        return $this->hasMany('Question');
    }

	public function fullname() 
	{
		return trim($this->title . " " . $this->first_name . " " . $this->last_name);
	}

    public function profilePicture()
    {
        return '/profile-pics/'.$this->profile_pic;
    }

}