<?php

class Answer extends Eloquent {

    protected $table = 'answers';

    public  $timestamps = true;

    public static $rules = [
        'description' => 'required|between:2,2000',
    ];

    public $errors;

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function isValid($data)
    {
        $validation = Validator::make($data, static::$rules);

        if($validation->passes()) return true;

        $this->errors = $validation->messages();

        return false;
    }

    public function getNotification($action){
        $verb = '';
        if($action == 'create'){
            $verb = 'created';
        }else if($action == 'edit'){
            $verb = 'edited';
        }else{
            $verb = 'deleted';
        }

        return 'You successfully ' . $verb . ' your answer!';
    }

}