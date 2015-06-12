<?php

class WantedListingsController extends BaseController {

    public function getIndex(){


        $wanted = Wanted::paginate(9);

        $selected = null;
        if (isset($input['tags'])) {
            $tagarray = $input['tags'];
            $selected = array();

            foreach( $tagarray as $tags ) {
                $index = sizeof($selected);
                $selected[$index] = new stdClass();
                $selected[$index]->tag_id = $tags;
            }
        }
        $tagsselect = Tag::tagsForSelect($selected);



        $data = [];
        if(count($wanted)>0){
            $projects = NULL;
            $wantedTags = NULL;
            $projectUsers = null;
            $allreadyParticipating = NULL;
            $pending = NULL;
            foreach($wanted as $wantedItem){

                $project = Project::where('id', '=' , $wantedItem->project_id)->first();
                $projectUser = ProjectUser::where('project_id', '=' , $wantedItem->project_id)->where('accepted_at','!=' , '0000-00-00 00:00:00')->where('accepted_at', '>' , $wantedItem->created_at)->get();
                $projectUsers[$wantedItem->id]= $projectUser;
                $projects[$wantedItem->id] = $project;
                $tags = $wantedItem->tags;
                $wantedTags[$wantedItem->id] = $tags;
                $participant = NULL;
                if(Sentry::check()){
                    $participant = ProjectUser::where('project_id' , '=' ,$wantedItem->project_id)->where('user_id', '=' , Sentry::getUser()->id )->first();
                }
                if($participant !== NULL)
                {
                    $allreadyParticipating[$wantedItem->id] = true;
                    if($participant->accepted_at === '0000-00-00 00:00:00'){
                        $pending[$wantedItem->id] = true;
                    }
                }
                else {
                    $allreadyParticipating[$wantedItem->id] = false;
                }

            }

            $selected = null;
            if (isset($input['tags'])) {
                $tagarray = $input['tags'];
                $selected = array();

                foreach( $tagarray as $tags ) {
                    $index = sizeof($selected);
                    $selected[$index] = new stdClass();
                    $selected[$index]->tag_id = $tags;
                }
            }
            $tagsselect = Tag::tagsForSelect($selected);

            $data['wanted'] = $wanted;
            $data['projects'] = $projects;
            $data['wantedTags'] = $wantedTags;
            $data['projectUsers'] = $projectUsers;
            $data['allreadyParticipating'] = $allreadyParticipating;
            $data['pending'] = $pending;
            $data['tagsselect'] = $tagsselect;
        }
        return View::make('site/wantedListings/wantedListings', $data)->with('tagsselect', $tagsselect);
    }



    public function getParticipate($project_id)
    {
          $projectUser = new ProjectUser();
          $projectUser->project_id = $project_id;
          $projectUser->user_id = Sentry::getUser()->id;
          $projectUser->owner = false;
          $projectUser->manager = false;
          $projectUser->accepted_at = '0000-00-00 00:00:00';
          $projectUser->save();
        return Redirect::to('/project/'.$project_id)->with('success', 'You have successfully applied for this project!');
    }

    public function postProfile()
    {
        //
    }

    public function anyLogin()
    {
        //
    }
}