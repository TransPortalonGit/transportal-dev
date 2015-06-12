<?php

namespace App\Modules\Analytics\Controllers\Admin;
use View;

class AnalyticsController extends \BaseController 
{

	public function getIndex()	
	{ 
		return View::make('analytics::index');
	}

}