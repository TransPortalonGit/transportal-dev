<?php

class HomeController extends BaseController {

	public function getIndex()	{
		$usersinlab = User::where('inlab', '=', 1)->get();
		$projects = Project::orderBy('created_at', 'desc')->paginate(3);

		$popProjects = Project::orderBy('favorite', 'desc')->paginate(3);

	    return View::make('site/home/index')
	    			->with('projects', $projects)
	    			->with('usersinlab', $usersinlab)
	    			->with('popProjects', $popProjects);
	}

}

?>