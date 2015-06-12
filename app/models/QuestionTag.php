<?php

class QuestionTag extends Eloquent {

    public function question()
    {
        return $this->belongsTo('Question');
    }

    public function tag(){
        return $this->belongsTo('Tag');
    }

} 