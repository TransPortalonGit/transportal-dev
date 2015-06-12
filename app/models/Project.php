<?php

class Project extends Eloquent {

	protected $table = 'projects';

    protected $guarded = ['id', 'created_at', 'updated_at'];

	public  $timestamps = true;
	
	public function user()
    {
        return $this->belongsTo('User');
    }

    public function projectusers()
    {
        return $this->hasMany('ProjectUser');
    }

    public function wanted()
    {
        return $this->hasOne('Wanted');
    }

    public static function validate($input) {
        $messages = array(
            'content.required' => 'Please try to write a few words about your project.'
        );

        $rules = array(
            'title' => array('required', 'min:5'),
            'content' => array('required', 'max:500'),
        );
       return Validator::make($input, $rules, $messages);
    }

    public function projectsessions()
    {
        return $this->hasMany('ProjectSession');
    }

}