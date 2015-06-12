<?php

class UserProjectController extends BaseController {

	public function getIndex()	{
		$user = Sentry::getUser();
	    return View::make('site/profile/project')
	    	->with('user', $user);
	}

}