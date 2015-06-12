<?php
namespace Profile;
use View;

class UsageDataController extends \BaseController {

	public function get_index()	{

		if (!\Sentry::check()) return \Redirect::to('account/login') ;

		$currentuser = \Sentry::getUser();
		$username = $currentuser->username;

	    return View::make('site/profile/usagedata/index')
			   	->with('user', \Sentry::getUser())
			   	->with('username', $username);    	
	}

}