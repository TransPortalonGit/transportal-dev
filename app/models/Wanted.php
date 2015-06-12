<?php

class Wanted extends Eloquent {

    public function project()
    {
        return $this->belongsTo('Project');
    }

    public function tags()
    {
        return $this->hasMany('WantedTag');
    }

    public function scopeAll(){
        return Wanted::all();
    }

    public function scopeSearch($query, $search){
        return $query->where('title', 'LIKE', "%$search%");
    }

    public function scopeYours($query, $serach){
        return $query->where('user_id', '=', $serach );
    }

    public function scopeGiveQuery($query){
        return $query;
    }

    public function scopeDescCreatedAt($query){
        return $query->orderBy('created_at', 'DESC');
    }

    public function scopeAscCreatedAt($query){
        return $query->orderBy('created_at', 'ASC');
    }

    public function scopeTagfilter($query, $array){
        $wantedIds = array();
        foreach($array AS $tag){
            $wantedTags = WantedTag::where('tag_id', '=', $tag)->get();
            foreach($wantedTags AS $wantedTag){
                $wantedIds[] = $wantedTag->id;
            }
        }
        return $query->whereIn('id', $wantedIds);
    }

} 