<?php

class ProjectUser extends Eloquent {

    public function project()
    {
        return $this->belongsTo('Project');
    }

    public function user(){
        return $this->belongsTo('User');
    }

    public function accept()
    {
        $this->accepted_at = date('Y-m-d H:i:s');
        $this->save();
    }

    public function deny()
    {
        $this->delete();
    }

} 