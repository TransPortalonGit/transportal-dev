<?php

class ListingTag extends Eloquent {

    public $timestamps = false;

    public function listing()
    {
        return $this->belongsTo('Listing');
    }

    public function tag(){
        return $this->belongsTo('Tag');
    }

}