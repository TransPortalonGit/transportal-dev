<?php

class ProjectUsersController extends BaseController
{
    public function show($id)
    {
        $project = Project::find($id);
        $projectUsers = $project->projectUsers;
        $acceptedCount = 0;
        foreach($projectUsers AS $projectUser){
            if($projectUser->accepted_at !== '0000-00-00 00:00:00'){
                $acceptedCount++;
            }
        }
        if(Sentry::check() && $project->user_id === Sentry::getUser()->id){
            return View::make('site/projectUsers/show')->with('project',$project)
                ->with('user', Sentry::getUser()->id)
                ->with('acceptedCount', $acceptedCount);
        }else{
            return Redirect::to('project/'.$project->id);
        }
    }

    public function store(){
        $input = Input::all();
        $projectUser = new ProjectUser();
        $projectUser->project_id = $input['project_id'];
        $projectUser->user_id = Sentry::getUser()->id;
        $projectUser->manager = false;
        $projectUser->accepted_at = '0000-00-00 00:00:00';
        $projectUser->save();
        return Redirect::to('/project/'.$input['project_id'])->with('success', 'You have successfully applied for this project!');
    }

    public function update($id)
    {
        $projectUser = ProjectUser::find($id);
        $input = Input::all();
        if(isset($input['accept']) && $input['accept'] == '1'){
            $projectUser->accept();
            return Redirect::to('/projectUsers/'.$projectUser->project_id)->with('success', 'You have accepted the user!');
        }elseif(isset($input['accept']) && $input['accept'] == '0'){
            $projectUser->deny();
            return Redirect::to('/projectUsers/'.$projectUser->project_id)->with('success', 'You have denied the user!');
        }
    }

    public function destroy($id)
    {
        $projectUser = ProjectUser::find($id);
        $projectUser->delete();
        return Redirect::to('/projectUsers/'.$projectUser->project_id)->with('success', 'You have removed the user!');
    }

}

?>
