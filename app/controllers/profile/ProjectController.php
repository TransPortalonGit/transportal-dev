<?php
namespace Profile;
use View;

class ProjectController extends \BaseController {


	public function getIndex()	
	{
		$user = \Sentry::getUser();
		$count = \Project::where('user_id', '=', $user->id)->count();
		$username = $user->username;
		$sortby = \Input::get('pporder');
		$projects = \Project::where('user_id', '=', $user->id)->paginate(8);

		if($sortby)
		{
			if($sortby == 'title')
			{
				$projects = \Project::where('user_id', '=', $user->id)->orderBy($sortby, 'asc')->paginate(8);
			}
			else
			{
				$projects = \Project::where('user_id', '=', $user->id)->orderBy($sortby, 'desc')->paginate(8);
			}
		}

	    return View::make('site/profile/projects/index')
	    			->with('projects', $projects)
	    			->with('user', $user)
	    			->with('count', $count)
	    			->with('username', $username)
	    			->with('sortby', $sortby);	  	    	
	}

}