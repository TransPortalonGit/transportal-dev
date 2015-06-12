<?php

namespace Admin;
use View;

class HomeController extends \BaseController {

	public function getIndex()	{
	    return View::make('admin/home/index');
	}

}