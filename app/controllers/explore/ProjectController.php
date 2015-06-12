<?php
namespace Explore;
use View;

class ProjectController extends \BaseController {


	public function get_index()	{

		$user = \Sentry::getUser();

		return View::make('site/explore/projects/index')
	   					->with('user', $user);
			   	    	
	}

}
