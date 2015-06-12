<?php

class Question extends Eloquent {

    protected $table = 'questions';

    public  $timestamps = true;

    public static $rules = [
        'title' => 'required|between:2,60',
        'description' => 'required|between:2,2000',
    ];

    public $errors;

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function tags() {
        return $this->hasMany('QuestionTag');
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

        return 'You successfully ' . $verb . ' the question "' . $this->title . '"!';
    }

    public function scopeAll(){
        return Question::all();
    }

    public function scopeYours($query){
        return $query->where('user_id', '=', 121 ); //Get user with Sentry?
    }

    public function scopeProject($query, $project_id){
        return $query->where('project_id', '=', $project_id ); //Get user with Sentry?
    }

    public function scopeGiveQuery($query){
        return $query;
    }

    public function scopeSearch($query, $search){
        return $query->where('title', 'LIKE', "%$search%");
    }

    public function scopeDescCreatedAt($query){
        return $query->orderBy('created_at', 'DESC');
    }

    public function scopeAscCreatedAt($query){
        return $query->orderBy('created_at', 'ASC');
    }

    public function scopeTagfilter($query, $array){
        $questionIds = array();
        foreach($array AS $tag){
            $questionTags = QuestionTag::where('tag_id', '=', $tag)->get();
            foreach($questionTags AS $questionTag){
                $questionIds[] = $questionTag->question_id;
            }
        }
        return $query->whereIn('id', $questionIds);
    }

}