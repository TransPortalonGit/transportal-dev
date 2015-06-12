<?php

class WantedTag extends Eloquent {

    public function wanted()
    {
        return $this->belongsTo('Wanted');
    }

    public function tag(){
        return $this->belongsTo('Tag');
    }

} 