<?php

class WantedController extends BaseController {

    public function create()
    {
        $project_id = $_GET['project_id'];
        $project = Project::find($project_id);
        $wanted = $project->wanted;
        if($wanted !== null){
            return Redirect::to('/wanted/'.$wanted->id.'/edit');
        }
        if(Sentry::check() && Sentry::getUser()->id === $project->user_id){
            $tagsselect = Tag::tagsForSelect();
            return View::make('site/wanted/create')
                ->with('project', $project)
                ->with('tagsselect', $tagsselect);
        }else{
            //Session::flash('message', 'Access not allowed!');
            //Session::flash('alert-class', 'alert-warning');
            return Redirect::to('/project/'.$wanted->project_id);
        }
    }

    public function store()
    {
        // ToDo rules ins Model
        $rules = array(
            'wanted_count'  =>  array('required', 'Integer', 'Min:1'),
            'description'   =>  array('required', 'Min:5', 'Max:1000')
            // ToDo Tags rules - einmal für alle Teilprojekte
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('/wanted/create?project_id=' . Input::get('project_id'))->withErrors($validator)->withInput();
        }

        $wanted = new Wanted;
        $wanted->wanted_count = trim(Input::get('wanted_count'));
        $wanted->description = trim(Input::get('description'));
        $wanted->project_id = trim(Input::get('project_id'));
        $wanted->save();

        $tags = Input::get('tags');
        if(!empty($tags)){
            foreach($tags AS $tag){
                $wanted_tag = new WantedTag();
                $wanted_tag->wanted_id = $wanted->id;
                $wanted_tag->tag_id = $tag;
                $wanted_tag->save();
            }
        }

        return Redirect::to('/project/' . Input::get('project_id'))->with('success', 'Wanted successfully saved!');
    }

    public function edit($id)
    {
        $wanted = Wanted::find($id);
        if($wanted === null){
            return Redirect::to('/home');
        }
        $project = $wanted->project;
        if(Sentry::check() && Sentry::getUser()->id === $project->user_id){
            $selectedttags = $wanted->tags;
            $tagsselect = Tag::tagsForSelect($selectedttags);
            return View::make('site/wanted/edit')
                ->with('wanted', $wanted)
                ->with('project', $project)
                ->with('tagsselect', $tagsselect);
        }else{
            //Session::flash('message', 'Access not allowed!');
            //Session::flash('alert-class', 'alert-warning');
            return Redirect::to('/project/'.$wanted->project_id);
        }
    }

    public function update($id)
    {
        $wanted = Wanted::find($id);
        $wanted->wanted_count = Input::get('wanted_count');
        $wanted->description = Input::get('description');
        $wanted->save();
        $tags = Input::get('tags');
        WantedTag::where("wanted_id", $wanted->id)->delete();
        if(!empty($tags)){
            foreach($tags AS $tag){
                $wanted_tag = new WantedTag();
                $wanted_tag->wanted_id = $wanted->id;
                $wanted_tag->tag_id = $tag;
                $wanted_tag->save();
            }
        }
        return Redirect::to('/project/' . Input::get('project_id'))->with('success', 'Wanted successfully updated!');
    }

    public function destroy($id)
    {
        $wanted = Wanted::find($id);
        $project_id = $wanted->project_id;
        WantedTag::where("wanted_id", $id)->delete();
        ProjectUser::where("project_id", $project_id)->where("accepted_at", "=", "0000-00-00 00:00:00")->delete();
        $wanted->delete();
        return Redirect::to('/project/' . $project_id)->with('success', 'Wanted successfully deleted!');
    }

} 