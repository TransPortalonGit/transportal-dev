<?php
namespace Explore;
use View;

class ToolController extends \BaseController {


	public function get_index()	{
	   return View::make('site/explore/labtools/index')->with('user', \Sentry::getUser());
			   	    	
	}

}

	