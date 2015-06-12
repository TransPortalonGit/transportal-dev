<?php

class Tag extends Eloquent {

    public function getParent()
    {
        return $this->belongsTo('Tag', 'parent');
    }

    public function children()
    {
        return $this->hasMany('Tag', 'parent');
    }

    public function wanteds()
    {
        return $this->belongsToMany('Wanted');
    }

    public static function tagsArray()
    {
        $tags = Tag::all();
        $tags_array = array();
        foreach($tags AS $tag){
            if($tag->parent !== NULL){
                $tags_array[$tag->parent]['tags'][$tag->id] = $tag->tag;
            }else{
                $tags_array[$tag->id]['parent'] = $tag->tag;
            }
        }
        return $tags_array;
    }

    public static function tagsForSelect($selectedtags = null)
    {
        $tags = array();
        $tags['options'] = Tag::tagsArray();
        $tags['selected'] = array();
        if($selectedtags !== null && sizeof($selectedtags) > 0){
            foreach($selectedtags AS $selectedtag){
                $tags['selected'][$selectedtag->tag_id] = $selectedtag->tag_id;
            }
        }
        return $tags;
    }

}