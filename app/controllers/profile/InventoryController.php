<?php

namespace Profile;

use App\Modules\Inventory\Models\Transaction,
	View;

class InventoryController extends \BaseController {


	public function getIndex()	{

		$user = \Sentry::getUser();
		$transactions = Transaction::where('user_id', '=', $user->id)->paginate(10);
		$today = date('Y-m-d H:i:s');

		$items = \DB::table('items')
						->join('transactions', 'items.id', '=', 'transactions.item_id')
						->get();

		$i = 0;
		$dueitemcount = 0;

		return View::make('site/profile/inventory/index')
						->with('user', $user)
						->with('transactions', $transactions)
						->with('items', $items)
						->with('today', $today)
						->with('dueitemcount', $dueitemcount)
						->with('i', $i);	    	
	}

}