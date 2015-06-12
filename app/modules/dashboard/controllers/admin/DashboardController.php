<?php

namespace App\Modules\Dashboard\Controllers\Admin;

use App\Modules\Inventory\Models\Item,
	App\Modules\Inventory\Models\Itemsuser,
	View;

/**
 * Dashboard controller
 * @author Stefanos-Rafail Trialonis <strialonis@gmail.com>
 */

class DashboardController extends \BaseController 
{

	public function getIndex()	
	{ 
		$items = Item::all();
		$itemsusers = Itemsuser::all();
		$users = \User::all();
		$totalarticles = 0;
		$totalarticlesloaned = 0;

		// Select the active users
		$activeusers = \User::where('activated', '=', "1")->get();
	    $inactiveusers = \User::where('activated', '=', "0")->get();

	    // Select the users in lab
	    $usersinlab = \User::where('inlab', '=', 1)->get();

	    return View::make('dashboard::index')
	    				->with('itemsusers', $itemsusers)
	    				->with('users', $users)
	    				->with('items', $items)
	    				->with('totalarticles', $totalarticles)
	    				->with('totalarticlesloaned', $totalarticlesloaned)
	    				->with('inactiveusers', $inactiveusers)
	    				->with('activeusers', $activeusers)
	    				->with('usersinlab', $usersinlab);
	}
}