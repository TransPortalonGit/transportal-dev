<?php
namespace Explore;
use View;

class MemberController extends \BaseController {


	public function get_index()	
	{
		$users = \User::orderBy('username', 'asc')->paginate(8);
		$sortby = \Input::get('m_order');

		if($sortby)
		{
			if($sortby == 'created_at')
			{
				$users = \User::orderBy($sortby, 'desc')->paginate(8);
			}
			else
			{
				$users = \User::orderBy($sortby, 'asc')->paginate(8);
			}
		}

		return View::make('site/explore/members/index')
	   					->with('users', $users)
	   					->with('sortby', $sortby);	   	    	
	}

	public function getSearch() 
	{
		$searchInput = \Input::get('search');
		$searchTerms = explode(' ', $searchInput);
		$sortby = \Input::get('m_order');

		$query = \DB::table('users');

		foreach($searchTerms as $term)
		{
			$query->where('username', 'LIKE', '%' . $term . '%');
		}

		$users = $query->orderBy('username', 'asc')->paginate(8);

		if($sortby)
		{
			if($sortby == 'created_at')
			{
				$users = \User::orderBy($sortby, 'desc')->paginate(8);
			}
			else
			{
				$users = \User::orderBy($sortby, 'asc')->paginate(8);
			}
		}

		return View::make('site/explore/members/index')
				->with('users', $users)
				->with('sortby', $sortby);
	}

}

	