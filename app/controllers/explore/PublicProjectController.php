<?php
namespace Explore;
use View;

class PublicProjectController extends \BaseController {


	public function get_index()	
	{
		$user = \Sentry::getUser();
		$projects = \Project::orderBy('title', 'asc')->paginate(8);
		$sortby = \Input::get('pporder');

		if($sortby)
		{
			if($sortby == 'title')
			{
				$projects = \Project::orderBy($sortby, 'asc')->paginate(8);
			}
			else
			{
				$projects = \Project::orderBy($sortby, 'desc')->paginate(8);
			}
		}

		return View::make('site/explore/publicprojects/index')
	   					->with('user', $user)
	   					->with('projects', $projects)
	   					->with('sortby', $sortby);	   	    	
	}

	public function getSearch() 
	{
		$searchInput = \Input::get('search');
		$searchTerms = explode(' ', $searchInput);
		$sortby = \Input::get('pporder');

		$query = \DB::table('projects');

		foreach($searchTerms as $term)
		{
			$query->where('title', 'LIKE', '%' . $term . '%');
		}

		$projects = $query->orderBy('title', 'asc')->paginate(8);

		if($sortby)
		{
			if($sortby == 'title')
			{
				$projects = \Project::orderBy($sortby, 'asc')->paginate(8);
			}
			else
			{
				$projects = \Project::orderBy($sortby, 'desc')->paginate(8);
			}
		}

		return View::make('site/explore/publicprojects/index')
				->with('projects', $projects)
				->with('sortby', $sortby);
	}

}

	