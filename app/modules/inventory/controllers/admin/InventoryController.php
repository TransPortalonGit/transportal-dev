<?php

namespace App\Modules\Inventory\Controllers\Admin;

use App\Modules\Inventory\Models\Room,
	App\Modules\Inventory\Models\Cabinet,
	App\Modules\Inventory\Models\Surface,
	App\Modules\Inventory\Models\Box,
	App\Modules\Inventory\Models\Item,
	App\Modules\Inventory\Models\Transaction,
	App\Modules\Inventory\Models\Relation,
	App\Modules\Inventory\Models\Repair,
	View;

/**
 * Inventory controller
 * @author Stefanos-Rafail Trialonis <strialonis@gmail.com>
 */

class InventoryController extends \BaseController
{

	public function getIndex()
	{
		\Session::forget('code');
		\Session::forget('next');

		$room_count = Room::all()->count();
		$cabinet_count = Cabinet::all()->count();
		$surface_count = Surface::all()->count();
		$box_count = Box::all()->count();
		$item_count = Item::all()->count();
		$lendings = Transaction::where('type', '=', 'lend')->get();
		$transactions = Transaction::paginate(10);
		
		$users = \DB::table('users')
						->join('transactions', 'users.id', '=', 'transactions.user_id')
						->get();

		$items = \DB::table('items')
						->join('transactions', 'items.id', '=', 'transactions.item_id')
						->get();

		$broken_items = \DB::table('repairs')
						->join('items', 'repairs.item_id', '=', 'items.id')
						->join('relations', 'repairs.item_id', '=', 'relations.ref_id')
						->select('repairs.id', 'repairs.quantity', 'relations.code', 'items.name', 'repairs.description')
						->paginate(10);

		$i = 0;

		return View::make('inventory::index')
						->with('room_count', $room_count)
						->with('cabinet_count', $cabinet_count)
						->with('surface_count', $surface_count)
						->with('box_count', $box_count)
						->with('item_count', $item_count)
						->with('lendings', $lendings)
						->with('transactions', $transactions)
						->with('users', $users)
						->with('items', $items)
						->with('broken_items', $broken_items)
						->with('i', $i);
	}


	// is getLendings valid?
	public function getLendings()
	{
		$transactions = Transaction::paginate(10);
		
		$users = \DB::table('users')
						->join('transactions', 'users.id', '=', 'transactions.user_id')
						->get();

		$items = \DB::table('items')
						->join('transactions', 'items.id', '=', 'transactions.item_id')
						->get();

		$i = 0;

		return View::make('admin/lendings')
						->with('transactions', $transactions)
						->with('users', $users)
						->with('items', $items)
						->with('i', $i);
	}


	public function getLend($id)
	{
		$users = \User::all();
		$item = Item::where('id', '=', $id)->first();

		return View::make('inventory::lend')->with('item', $item)->with('users', $users)->with('id', $id);
	}


	public function postLend()
	{
		$currentDate = date('m-d-Y');

		$rules = array(
			'due_date'		=> 'required|after:currentDate',
			'quantity'		=> 'required',
			'auto'			=> 'required');

		$validator = \Validator::make(\Input::all(), $rules);

		if ($validator->passes())
		{
			$item = Item::where('name', '=', \Input::get('item_name'))->first();
			$user = \User::where('username', '=', \Input::get('auto'))->first();

			$transaction = new \Transaction;
			$transaction->item_id = $item->id;
			$transaction->quantity = \Input::get('quantity');
			$transaction->user_id = $user->id;
			$transaction->type = 1;
			$transaction->due_date = \Input::get('due_date');
			$transaction->save();

			$item->quantity = $item->quantity-$transaction->quantity;
			$item->save();

			return \Redirect::to('/admin/inventory/list/items')->with('success', $item->name . ' was successfully lend to ' . $user->username . '.');
		}
		else
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}
	}


	// is this working?
	public function postSearch()
	{
		$query = \Input::get('query');

		if($query[0] == 'R')
		{
			$results = \DB::table('relations')
						->join('rooms', 'relations.ref_id', '=', 'rooms.id')
						->where('code', '=', $query)
						->get();
		}

		if($query[0] == 'C')
		{
			$results = \DB::table('relations')
						->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
						->where('code', '=', $query)
						->get();
		}
		
		if($query[0] == 'S')
		{
			$results = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('code', '=', $query)
						->get();
		}

		if($query[0] == 'B')
		{
			$results = \DB::table('relations')
						->join('boxes', 'relations.ref_id', '=', 'boxes.id')
						->where('code', '=', $query)
						->get();
		}

		if($query[0] == 'I')
		{
			$results = \DB::table('relations')
						->join('items', 'relations.ref_id', '=', 'items.id')
						->where('code', '=', $query)
						->get();
		}

		return View::make('admin/results')->with('query', $query)->with('results', $results);

	}


	public function getList($type)
	{
		if($type == 'rooms')
		{
			$rooms = \DB::table('relations')
						->join('rooms', 'relations.ref_id', '=', 'rooms.id')
						->where('type', '=', 'room')
						->paginate(10);

			return View::make('inventory::list')->with('rooms', $rooms)->with('type', $type);	
		}

		if($type == 'cabinets')
		{
			$cabinets = \DB::table('relations')
						->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
						->where('type', '=', 'cabinet')
						->paginate(10);

			return View::make('inventory::list')->with('cabinets', $cabinets)->with('type', $type);	
		}

		if($type == 'surfaces')
		{
			$surfaces = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('type', '=', 'surface')
						->paginate(10);

			return View::make('inventory::list')->with('surfaces', $surfaces)->with('type', $type);	
		}

		if($type == 'boxes')
		{
			$boxes = \DB::table('relations')
						->join('boxes', 'relations.ref_id', '=', 'boxes.id')
						->where('type', '=', 'box')
						->paginate(10);

			return View::make('inventory::list')->with('boxes', $boxes)->with('type', $type);	
		}
		
		if($type == 'items')
		{
			$items = \DB::table('relations')
						->join('items', 'relations.ref_id', '=', 'items.id')
						->where('type', '=', 'item')
						->paginate(10);

			return View::make('inventory::list')->with('items', $items)->with('type', $type);	
		}

		if($type == 'broken')
		{
			$broken_items = \DB::table('repairs')
						->join('items', 'repairs.item_id', '=', 'items.id')
						->join('relations', 'repairs.item_id', '=', 'relations.ref_id')
						->select('repairs.id', 'repairs.quantity', 'relations.code', 'items.name', 'repairs.description')
						->paginate(10);

			return View::make('inventory::list')->with('broken_items', $broken_items)->with('type', $type);	
		}
	}


	public function getView($code)
	{
		if($code[0] == 'R')
		{
			$room = \DB::table('relations')
					->join('rooms', 'relations.ref_id', '=', 'rooms.id')
					->where('code', '=', $code)
					->get();

			return View::make('inventory::view')->with('code', $code)->with('room', $room);
		}

		if($code[0] == 'C')
		{
			$cabinet = \DB::table('relations')
					->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
					->where('code', '=', $code)
					->get();

			return View::make('inventory::view')->with('code', $code)->with('cabinet', $cabinet);
		}

		if($code[0] == 'S')
		{
			$surface = \DB::table('relations')
					->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
					->where('code', '=', $code)
					->get();

			$container_cabinet = \DB::table('relations')
					->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
					->where('code', '=', $surface[0]->parent_code)
					->get();

			$all_surfaces = \DB::table('relations')
					->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
					->where('parent_code', '=', $surface[0]->parent_code)
					->orderBy('surfaces.column')
					->orderBy('surfaces.row')
					->get();

			$number_of_surfaces = count($all_surfaces);
			$row_extensions = array();
			$total_surfaces = array();
			$surface_matrix = array();

			for($i=0; $i<$container_cabinet[0]->columns; $i++)
			{
				array_push($total_surfaces, 0);
				
				for($j=0; $j<$number_of_surfaces; $j++)
				{
					if($all_surfaces[$j]->row >= 1 && $all_surfaces[$j]->column == $i)
					{
						$total_surfaces[$i] = $total_surfaces[$i]+1;
					}
				}
			}

			if($number_of_surfaces > 2)
			{
				$j=0;
				for($i=0; $i<$container_cabinet[0]->columns; $i++)
				{
					if($all_surfaces[$j]->row < $all_surfaces[$j]->row && !$j >= $number_of_surfaces);
					{
						$j++;
					}

					if($surface[0]->column == $all_surfaces[$j]->column && $all_surfaces[$j]->row == 1)
					{
						array_push($row_extensions, 0);
					}
					else
					{
						array_push($row_extensions, 1);
					}
				}

				for($k=0; $k<$container_cabinet[0]->columns; $k++)
				{
					$surface_matrix[$k] = $row_extensions[$k] + $total_surfaces[$k];
				}
			}

			return View::make('inventory::view')
							->with('code', $code)
							->with('surface', $surface)
							->with('container_cabinet', $container_cabinet)
							->with('all_surfaces', $all_surfaces)
							->with('number_of_surfaces', $number_of_surfaces)
							->with('surface_matrix', $surface_matrix);
		}

		if($code[0] == 'B')
		{
			$box = \DB::table('relations')
					->join('boxes', 'relations.ref_id', '=', 'boxes.id')
					->where('code', '=', $code)
					->get();

			$assigned_surface_code = $box[0]->parent_code;

			$assigned_surface = \DB::table('relations')
									->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
									->where('code', '=', $assigned_surface_code)
									->get();

			$assigned_cabinet_code = $assigned_surface[0]->parent_code;

			$selected_cabinet_code = \Input::get('cabinet2');
			$selected_cabinet = \Input::get('cabinet2');

			$selected_surface_code = \Input::get('surface');
			$selected_surface = \Input::get('surface');

			$cabinets = \DB::table('relations')
						->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
						->where('type', '=', 'cabinet')
						->select('cabinets.columns', 'cabinets.description', 'cabinets.id', 'relations.code', 'relations.id', 'relations.parent_code')
						->get();

			$first_cabinet_code = $cabinets[0]->code;

			$surfaces = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('type', '=', 'surface')
						->where('parent_code', '=', $first_cabinet_code)
						->select('surfaces.column', 'surfaces.row', 'surfaces.description', 'relations.code', 'relations.id')
						->get();
			
			if($selected_cabinet_code)
			{
				$surfaces = \DB::table('relations')
								->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
								->where('type', '=', 'surface')
								->where('parent_code', '=', $selected_cabinet_code)
								->select('surfaces.row', 'surfaces.column', 'surfaces.description', 'relations.code', 'relations.id')
								->get();

				$selected_cabinet = \DB::table('relations')
									->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
									->where('code', '=', $selected_cabinet_code)
									->select('cabinets.columns', 'cabinets.description', 'relations.code', 'relations.id', 'relations.parent_code')
									->get();
			}

			if($selected_surface_code)
			{
				$selected_surface = \DB::table('relations')
									->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
									->where('code', '=', $selected_surface_code)
									->select('surfaces.row', 'surfaces.column', 'surfaces.description', 'relations.code', 'relations.id')
									->get();
			}

			return View::make('inventory::view')
						->with('code', $code)
						->with('box', $box)
						->with('cabinets', $cabinets)
						->with('surfaces', $surfaces)
						->with('assigned_surface_code', $assigned_surface_code)
						->with('assigned_cabinet_code', $assigned_cabinet_code)
						->with('selected_cabinet', $selected_cabinet)
						->with('selected_cabinet_code', $selected_cabinet_code)
						->with('selected_surface', $selected_surface)
						->with('selected_surface_code', $selected_surface_code);
		}

		if($code[0] == 'I')
		{
			$item = \DB::table('relations')
					->join('items', 'relations.ref_id', '=', 'items.id')
					->where('code', '=', $code)
					->get();

			$nests = array('box', 'surface', 'room');
			$selected_nest = \Input::get('nest');
			
			$compartments = \DB::table('relations')
						->join('boxes', 'relations.ref_id', '=', 'boxes.id')
						->where('type', '=', 'box')
						->select('relations.code', 'relations.id')
						->get();

			$pre_selected_compartment = $item[0]->parent_code;

			if($selected_nest)
			{
				if($selected_nest == 'box')
				{
					$compartments = \DB::table('relations')
							->join('boxes', 'relations.ref_id', '=', 'boxes.id')
							->where('type', '=', 'box')
							->select('relations.code', 'relations.id')
							->get();
				}

				if($selected_nest == 'surface')
				{
					$compartments = \DB::table('relations')
							->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
							->where('type', '=', 'surface')
							->select('relations.code', 'relations.id')
							->get();
				}

				if($selected_nest == 'room')
				{
					$compartments = \DB::table('relations')
							->join('rooms', 'relations.ref_id', '=', 'rooms.id')
							->where('type', '=', 'room')
							->select('relations.code', 'relations.id')
							->get();
				}
			}

			if($pre_selected_compartment[0] == 'B')
			{
				$pre_selected_nest = 'box';

				$precompartments = \DB::table('relations')
							->join('boxes', 'relations.ref_id', '=', 'boxes.id')
							->where('type', '=', 'box')
							->select('relations.code', 'relations.id')
							->get();
			}
			elseif($pre_selected_compartment[0] == 'S')
			{
				$pre_selected_nest = 'surface';

				$precompartments = \DB::table('relations')
							->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
							->where('type', '=', 'surface')
							->select('relations.code', 'relations.id')
							->get();
			}
			elseif($pre_selected_compartment[0] == 'R')
			{
				$pre_selected_nest = 'room';

				$precompartments = \DB::table('relations')
							->join('rooms', 'relations.ref_id', '=', 'rooms.id')
							->where('type', '=', 'room')
							->select('relations.code', 'relations.id')
							->get();
			}

			return View::make('inventory::view')
						->with('code', $code)
						->with('item', $item)
						->with('nests', $nests)
						->with('selected_nest', $selected_nest)
						->with('compartments', $compartments)
						->with('pre_selected_nest', $pre_selected_nest)
						->with('pre_selected_compartment', $pre_selected_compartment)
						->with('precompartments', $precompartments);
		}

		if($code[0] == 'T')
		{
			$transaction_id = str_replace("T", "", $code);;
			$items = Item::all();
			$users = \User::all();
			$transaction = Transaction::where('id', '=', $transaction_id)->first();
			$assigned_user = \User::where('id', '=', $transaction->user_id)->first();
			$assigned_item = Item::where('id', '=', $transaction->item_id)->first();


			return View::make('inventory::view')
						->with('code', $code)
						->with('items', $items)
						->with('users', $users)
						->with('assigned_user', $assigned_user)
						->with('assigned_item', $assigned_item)
						->with('transaction', $transaction);
		}

	}


	public function postUpdate($code)
	{
		if($code[0] == 'R')
		{
			$room_id = \DB::table('relations')
					->join('rooms', 'relations.ref_id', '=', 'rooms.id')
					->where('code', '=', $code)
					->select('rooms.id')
					->get();

			$room = Room::find($room_id[0]->id);

			$rules = array(
			'name'					=> 'required|unique:rooms,name,'.$room->id);

			$validator = \Validator::make(\Input::all(), $rules);

			if($validator->passes())
			{
				$room->name = \Input::get('name');
				$room->save();

				return \Redirect::to('admin/inventory/list/rooms')->with('success', $code . ' has been updated!');
			}
			else
			{
				return \Redirect::back()->withInput()->withErrors($validator);
			}
		}

		if($code[0] == 'C')
		{
			$cabinet_id = \DB::table('relations')
					->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
					->where('code', '=', $code)
					->select('cabinets.id')
					->get();

			$codes_array = Relation::lists('code');
			$date = new \DateTime;

			$cabinet = Cabinet::find($cabinet_id[0]->id);
			$cabinet_columns_prev = $cabinet->columns;

			if(\Input::get('columns') > $cabinet_columns_prev)
			{
				$cabinet->description = \Input::get('description');
				$cabinet->columns = \Input::get('columns');
				$cabinet->save();

				for($i=$cabinet_columns_prev; $i<$cabinet->columns; $i++)
				{
					$surface = new \Surface;
					$surface->column = $i;
					$surface->row = '0';
					$surface->description = 'Bottom of the cabinet';
					$surface->save();

					do
					{
						$generated_code = 'S' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
						$is_duplicate = in_array($generated_code, $codes_array);
					} 
					while($is_duplicate == TRUE);

					$surface->relations()->insert(
					array(
						'code' => $generated_code, 
						'type' => '3', 
						'ref_id' => $surface->id,
						'parent_code' => $code,
						'created_at' => $date, 
						'updated_at' => $date
						)
					);
				}
			}

			return \Redirect::to('admin/inventory/list/cabinets')->with('success', $code . ' has been updated!');
		}

		if($code[0] == 'S')
		{
			$mod_surface_id = \DB::table('relations')
					->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
					->where('code', '=', $code)
					->select('surfaces.id', 'relations.parent_code')
					->get();

			$mod_surface = Surface::find($mod_surface_id[0]->id);

			$swap_surface = \DB::table('relations')
					->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
					->where('parent_code', '=', $mod_surface_id[0]->parent_code)
					->select('surfaces.id', 'surfaces.column', 'surfaces.row')
					->get();

			$level = str_split(\Input::get('level'));
			$array_index = -1;

			for($i=0; $i<count($swap_surface); $i++)
			{
				if($swap_surface[$i]->column == $level[0] && $swap_surface[$i]->row == $level[1])
				{
					$array_index = $i;
				}

			} /* find if a surface already exists on chosen mod_surface level */

			if($array_index > -1)
			{
				$mod_surface_2 = Surface::find($swap_surface[$array_index]->id);
			
				$mod_surface_2->row = $mod_surface->row;
				$mod_surface_2->column = $mod_surface->column;
				$mod_surface_2->save();

				$mod_surface->row = $level[1];
				$mod_surface->column = $level[0];
				$mod_surface->save();
			}
			else
			{
				for($i=0; $i<count($swap_surface); $i++)
				{
					if($swap_surface[$i]->column == $mod_surface->column && $swap_surface[$i]->row > $mod_surface->row)
					{
						$above_surface = Surface::find($swap_surface[$i]->id);

						$above_surface->row = $above_surface->row-1;
						$above_surface->save();
					}
				}

				$mod_surface->column = $level[0];
				$mod_surface->row = $level[1];
				$mod_surface->save();

			} /* if other surface exists: swap them ELSE just 
				move mod_surface and bring above surfaces (same column) -1 row */
			
			$mod_surface->description = \Input::get('description');
			$mod_surface->save();

			return \Redirect::to('admin/inventory/list/surfaces')->with('success', $code . ' has been updated!');
			
		}

		if($code[0] == 'B')
		{

			$box_id = \DB::table('relations')
					->join('boxes', 'relations.ref_id', '=', 'boxes.id')
					->where('code', '=', $code)
					->select('boxes.id')
					->get();

			$relation_id = \DB::table('relations')
					->join('boxes', 'relations.ref_id', '=', 'boxes.id')
					->where('code', '=', $code)
					->select('relations.id')
					->get();

			$relation = Relation::find($relation_id[0]->id);
			$box = Box::find($box_id[0]->id);

			if(\Input::get('surface'))
			{
				$relation->parent_code = \Input::get('surface');
				$relation->save();
			}

			$box->description = \Input::get('description');
			$box->save();

			return \Redirect::to('admin/inventory/list/boxes')->with('success', $code . ' has been updated!');
			
		}

		if($code[0] == 'I')
		{

			return \Redirect::to('admin/inventory/list/items')->with('success', $code . ' has been updated!');
			
		}

		if($code[0] == 'T')
		{
			$currentDate = date('m/d/Y');
			$item = item::where('name', '=', \Input::get('item_name'))->first();

			$rules = array(
				'due_date'		=> 'required|after:$currentDate',
				'quantity'		=> 'required|$item->quantity');

			$validator = \Validator::make(\Input::all(), $rules);

			if ($validator->passes())
			{
				$user = \user::where('id', '=', \Input::get('user'))->first();

				$transaction = new \Transaction;
				$transaction->item_id = $item->id;
				$transaction->quantity = \Input::get('quantity');
				$transaction->user_id = \Input::get('user');
				$transaction->type = 1;
				$transaction->due_date = \Input::get('due_date');
				$transaction->save();

				$item->quantity = $item->quantity-$transaction->quantity;
				$item->save();

				return \Redirect::to('/admin/inventory/list/items')->with('success', $item->name . ' was successfully lend to ' . $user->username . '.');
			}
			else
			{
				return \Redirect::back()->withInput()->withErrors($validator);
			}
		}

	}


	public function getDelete($code)
	{
		if($code[0] == 'R')
		{
			$room_id = \DB::table('relations')
					->join('rooms', 'relations.ref_id', '=', 'rooms.id')
					->where('code', '=', $code)
					->select('rooms.id')
					->get();

			$room = Room::find($room_id[0]->id);
			$relation = Relation::where('ref_id', '=', $room_id[0]->id)->where('type', '=', 'room')->first();

			$room->delete();
			$relation->delete();
			
			$cabinets_id = \DB::table('relations')
						->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
						->where('parent_code', '=', $code)
						->where('type', '=', 'cabinet')
						->select('cabinets.id', 'relations.code')
						->get();

			if($cabinets_id)
			{
				for($h=0; $h<count($cabinets_id); $h++)
				{
					$cabinet_to_del = Cabinet::find($cabinets_id[$h]->id);
					$cabinet_relation = Relation::where('ref_id', '=', $cabinet_to_del->id)->where('type', '=', 'cabinet')->first();

					$cabinet_to_del->delete();
					$cabinet_relation->delete();

					$surfaces_id = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('parent_code', '=', $cabinets_id[$h]->code)
						->where('type', '=', 'surface')
						->select('surfaces.id', 'relations.code')
						->get();

					if($surfaces_id)
					{
						for($i=0; $i<count($surfaces_id); $i++)
						{
							$surface_to_del = Surface::find($surfaces_id[$i]->id);
							$surface_relation = Relation::where('ref_id', '=', $surface_to_del->id)->where('type', '=', 'surface')->first();

							$surface_to_del->delete();
							$surface_relation->delete();

							$boxes_id = \DB::table('relations')
									->join('boxes', 'relations.ref_id', '=', 'boxes.id')
									->where('parent_code', '=', $surfaces_id[$i]->code)
									->where('type', '=', 'box')
									->select('boxes.id', 'relations.code')
									->get();

							if($boxes_id)
							{
								for($j=0; $j<count($boxes_id); $j++)
								{
									$box_to_del = Box::find($boxes_id[$j]->id);
									$box_relation = Relation::where('ref_id', '=', $box_to_del->id)->where('type', '=', 'box')->first();

									$box_to_del->delete();
									$box_relation->delete();

									$items_id = \DB::table('relations')
											->join('items', 'relations.ref_id', '=', 'items.id')
											->where('parent_code', '=', $boxes_id[$j]->code)
											->where('type', '=', 'item')
											->select('items.id', 'relations.code')
											->get();

									if($items_id)
									{
										for($k=0; $k<count($items_id); $k++)
										{
											$item_to_del = Item::find($items_id[$k]->id);
											$item_relation = Relation::where('ref_id', '=', $item_to_del->id)->where('type', '=', 'item')->first();

											$item_to_del->delete();
											$item_relation->delete();
										}
									}
								}
							}
						}
					}
				}
			}

			return \Redirect::to('admin/inventory/list/rooms')->with('success', $code . ' was deleted successfully.');
		}

		if($code[0] == 'C')
		{
			$cabinet_id = \DB::table('relations')
					->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
					->where('code', '=', $code)
					->select('cabinets.id')
					->get();

			$cabinet_to_del = Cabinet::find($cabinet_id[0]->id);
			$relation = Relation::where('ref_id', '=', $cabinet_id[0]->id)->where('type', '=', 'cabinet')->first();

			$cabinet_to_del->delete();
			$relation->delete();

			$surfaces_id = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('parent_code', '=', $code)
						->where('type', '=', 'surface')
						->select('surfaces.id', 'relations.code')
						->get();

			if($surfaces_id)
			{
				for($i=0; $i<count($surfaces_id); $i++)
				{
					$surface_to_del = Surface::find($surfaces_id[$i]->id);
					$surface_relation = Relation::where('ref_id', '=', $surface_to_del->id)->where('type', '=', 'surface')->first();

					$surface_to_del->delete();
					$surface_relation->delete();

					$boxes_id = \DB::table('relations')
							->join('boxes', 'relations.ref_id', '=', 'boxes.id')
							->where('parent_code', '=', $surfaces_id[$i]->code)
							->where('type', '=', 'box')
							->select('boxes.id', 'relations.code')
							->get();

					if($boxes_id)
					{
						for($j=0; $j<count($boxes_id); $j++)
						{
							$box_to_del = Box::find($boxes_id[$j]->id);
							$box_relation = Relation::where('ref_id', '=', $box_to_del->id)->where('type', '=', 'box')->first();

							$box_to_del->delete();
							$box_relation->delete();

							$items_id = \DB::table('relations')
									->join('items', 'relations.ref_id', '=', 'items.id')
									->where('parent_code', '=', $boxes_id[$j]->code)
									->where('type', '=', 'item')
									->select('items.id', 'relations.code')
									->get();

							if($items_id)
							{
								for($k=0; $k<count($items_id); $k++)
								{
									$item_to_del = Item::find($items_id[$k]->id);
									$item_relation = Relation::where('ref_id', '=', $item_to_del->id)->where('type', '=', 'item')->first();

									$item_to_del->delete();
									$item_relation->delete();
								}
							}
						}
					}
				}

				return \Redirect::to('admin/inventory/list/cabinets')->with('success', $code . ' was deleted successfully.');
			}
		}

		if($code[0] == 'S')
		{
			$surface_id = \DB::table('relations')
					->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
					->where('code', '=', $code)
					->select('surfaces.id', 'relations.parent_code')
					->get();

			$boxes_id = \DB::table('relations')
						->join('boxes', 'relations.ref_id', '=', 'boxes.id')
						->where('parent_code', '=', $code)
						->where('type', '=', 'box')
						->select('boxes.id')
						->get();

			$surface_to_del = Surface::find($surface_id[0]->id);

			if(!$surface_to_del->row == 0)
			{
				$relation = Relation::where('ref_id', '=', $surface_id[0]->id)->where('type', '=', 'surface')->first();

				$other_surfaces = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('parent_code', '=', $surface_id[0]->parent_code)
						->select('surfaces.id', 'surfaces.column', 'surfaces.row')
						->get();

				for($i=0; $i<count($other_surfaces); $i++)
				{
					if($other_surfaces[$i]->column == $surface_to_del->column && $other_surfaces[$i]->row > $surface_to_del->row)
					{
						$above_surface = Surface::find($other_surfaces[$i]->id);

						$above_surface->row = $above_surface->row-1;
						$above_surface->save();
					}
				}

				if($boxes_id)
				{
					for($i=0; $i<count($boxes_id); $i++)
					{
						$box_to_del = Box::find($boxes_id[$i]->id);
						$box_relation = Relation::where('ref_id', '=', $box_to_del->id)->where('type', '=', 'box')->first();

						$box_to_del->delete();
						$box_relation->delete();
					}
				}

				$surface_to_del->delete();
				$relation->delete();

				return \Redirect::to('admin/inventory/list/surfaces')->with('success', $code . ' was deleted successfully.');
			}
			else
			{
				return \Redirect::to('admin/inventory/list/surfaces')->with('error', 'You cannot delete the bottom cabinet!');
			}
		}

		if($code[0] == 'B')
		{
			$box_id = \DB::table('relations')
					->join('boxes', 'relations.ref_id', '=', 'boxes.id')
					->where('code', '=', $code)
					->select('boxes.id', 'relations.parent_code')
					->get();

			$items_id = \DB::table('relations')
						->join('items', 'relations.ref_id', '=', 'items.id')
						->where('parent_code', '=', $code)
						->where('type', '=', 'item')
						->select('items.id')
						->get();

			$box_to_del = Box::find($box_id[0]->id);

			$relation = Relation::where('ref_id', '=', $box_id[0]->id)->where('type', '=', 'box')->first();

			if($items_id)
			{
				for($i=0; $i<count($items_id); $i++)
				{
					$item_to_del = Item::find($items_id[$i]->id);
					$item_relation = Relation::where('ref_id', '=', $item_to_del->id)->where('type', '=', 'item')->first();

					$item_to_del->delete();
					$item_relation->delete();
				}
			}

			$result1 = $box_to_del->delete();
			$result2 = $relation->delete();

			if($result1 && $result2)
			{
				return \Redirect::to('admin/inventory/list/boxes')->with('success', $code . ' was deleted successfully.');
			}
			else
			{
				return \Redirect::to('admin/inventory/list/boxes')->with('error', 'Box ' . $code . ' could not be deleted!');
			}
		}

		if($code[0] == 'I')
		{
			$item_id = \DB::table('relations')
					->join('items', 'relations.ref_id', '=', 'items.id')
					->where('code', '=', $code)
					->select('items.id')
					->get();

			$item = Item::find($item_id[0]->id);

			$relation = Relation::where('ref_id', '=', $item_id[0]->id)->where('type', '=', 'item')->first();

			$result1 = $item->delete();
			$result2 = $relation->delete();
			
			if($result1 && $result2) 
			{
				return \Redirect::to('admin/inventory/list/items')->with('success', $code . ' was deleted successfully.');
			}	
			else 
			{
				return \Redirect::to('admin/inventory/list/items')->with('error', $code . ' could not be deleted.');
			}
		}

	}


	public function getReport($code, $qty)
	{
		$item_id = \DB::table('relations')
					->join('items', 'relations.ref_id', '=', 'items.id')
					->where('code', '=', $code)
					->select('items.id')
					->get();

		$item = Item::find($item_id[0]->id);

		if($qty == null)
		{
			return \Redirect::back()->with('error', 'Quantity cannot be null!');
		}
		elseif($qty > $item->quantity)
		{
			return \Redirect::back()->with('error', 'The input quantity cannot be bigger than the items quantity!');
		}
		else
		{
			$broken_item = new Repair;
			$broken_item->item_id = $item->id;
			$broken_item->quantity = $qty;
			$broken_item->description = "Reported as broken.";
			$broken_item->save();

			$item->quantity = $item->quantity - $qty;
			$item->save();

			return \Redirect::back()->with('success', 'Item ' . $code . ' was successfully reported as broken!'); 
		}
	}

	public function getDispose($id)
	{
		$broken_items = Repair::find($id);

		$broken_items->delete();

		return \Redirect::back()->with('success', 'Entry' . $id . ' was successfully disposed!');
	}


	public function getReturn($id)
	{
		$transaction = Transaction::where('id', '=', $id)->first();
		$item = Item::where('id', '=', $transaction->item_id)->first();

		$item->quantity = $item->quantity + $transaction->quantity;

		$result1 = $item->save();
		$result2 = $transaction->delete();

		if($result1 && $result2) 
		{
			return \Redirect::to('admin/inventory')->with('success', 'Item was returned successfully.');
		}	
		else 
		{
			return \Redirect::to('admin/inventory')->withErrors('error', 'Item could not be returned.');
		}

	}


	public function getCreate($type)
	{
		$codes_array = Relation::lists('code');

		if($type == 'room')
		{
			do
			{
				$generated_code = 'R' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
				$is_duplicate = in_array($generated_code, $codes_array);
			} 
			while($is_duplicate == TRUE);

			return View::make('inventory::create')->with('type', $type)->with('generated_code', $generated_code);	
		}

		if($type == 'cabinet')
		{

			$rooms = \DB::table('relations')
						->join('rooms', 'relations.ref_id', '=', 'rooms.id')
						->where('type', '=', 'room')
						->select('rooms.name', 'relations.code')
						->get();

			if(count($rooms) == 0)
			{
				return \Redirect::to('admin/inventory')->with('error', 'You must first create a room in order to create cabinets');
			} /* to be reviewed */

			do
			{
				$generated_code = 'C' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
				$is_duplicate = in_array($generated_code, $codes_array);
			} 
			while($is_duplicate == TRUE);

			return View::make('inventory::create')->with('type', $type)->with('generated_code', $generated_code)->with('rooms', $rooms);
		}

		if($type == 'surface')
		{
			$selected_cabinet_code = \Input::get('cabinet');
			$selected_cabinet = \Input::get('cabinet');

			$cabinets = \DB::table('relations')
						->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
						->where('type', '=', 'cabinet')
						->select('cabinets.columns', 'cabinets.description', 'relations.code', 'relations.id', 'relations.parent_code')
						->get();

			if(count($cabinets) == 0)
			{
				return \Redirect::to('admin/inventory')->with('error', 'You must first create a cabinet in order to create surfaces');
			} /* to be reviewed */

			if($selected_cabinet_code && !\Session::get('code'))
			{
				$selected_cabinet = \DB::table('relations')
									->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
									->where('code', '=', $selected_cabinet_code)
									->select('cabinets.columns', 'cabinets.description', 'relations.code', 'relations.id', 'relations.parent_code')
									->get();
			}
			elseif(!$selected_cabinet_code && \Session::get('code'))
			{
				$selected_cabinet_code = \Session::get('code');

				$selected_cabinet = \DB::table('relations')
									->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
									->where('code', '=', $selected_cabinet_code)
									->select('cabinets.columns', 'cabinets.description', 'relations.code', 'relations.id', 'relations.parent_code')
									->get();
			}

			return View::make('inventory::create')->with('type', $type)
											->with('cabinets', $cabinets)
											->with('selected_cabinet_code', $selected_cabinet_code)
											->with('selected_cabinet', $selected_cabinet);	
		}

		if($type == 'box')
		{
			$selected_cabinet_code = \Input::get('cabinet2');
			$selected_cabinet = \Input::get('cabinet2');

			$cabinets = \DB::table('relations')
						->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
						->where('type', '=', 'cabinet')
						->select('cabinets.columns', 'cabinets.description', 'cabinets.id', 'relations.code', 'relations.id', 'relations.parent_code')
						->get();

			if(count($cabinets) == 0)
			{
				return \Redirect::to('admin/inventory')->with('error', 'You must first create a cabinet in order to create boxes');
			} /* to be reviewed */

			$first_cabinet_code = $cabinets[0]->code;

			$surfaces = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('type', '=', 'surface')
						->where('parent_code', '=', $first_cabinet_code)
						->select('surfaces.column', 'surfaces.row', 'relations.code', 'relations.id')
						->get();
			
			if(\Session::get('code') != null)
			{
				$surfaces = \DB::table('relations')
								->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
								->where('type', '=', 'surface')
								->where('parent_code', '=', \Session::get('code'))
								->select('surfaces.row', 'surfaces.column', 'relations.code', 'relations.id')
								->get();
			} /* to be reviewed */

			if($selected_cabinet_code)
			{
				$surfaces = \DB::table('relations')
								->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
								->where('type', '=', 'surface')
								->where('parent_code', '=', $selected_cabinet_code)
								->select('surfaces.row', 'surfaces.column', 'relations.code', 'relations.id')
								->get();

				$selected_cabinet = \DB::table('relations')
									->join('cabinets', 'relations.ref_id', '=', 'cabinets.id')
									->where('code', '=', $selected_cabinet_code)
									->select('cabinets.columns', 'cabinets.description', 'relations.code', 'relations.id', 'relations.parent_code')
									->get();
			}


			return View::make('inventory::create')->with('type', $type)
											->with('cabinets', $cabinets)
											->with('surfaces', $surfaces)
											->with('selected_cabinet_code', $selected_cabinet_code)
											->with('selected_cabinet', $selected_cabinet);	
		}
		
		if($type == 'item')
		{
			$nests = array('box', 'surface', 'room');
			$selected_nest = \Input::get('nest');
			
			$compartments = \DB::table('relations')
						->join('boxes', 'relations.ref_id', '=', 'boxes.id')
						->where('type', '=', 'box')
						->select('relations.code', 'relations.id')
						->get();

			$rooms = \DB::table('relations')
						->join('rooms', 'relations.ref_id', '=', 'rooms.id')
						->where('type', '=', 'room')
						->select('rooms.name', 'relations.code')
						->get();

			if(count($rooms) == 0)
			{
				return \Redirect::to('admin/inventory')->with('error', 'You have nowhere to nest your items!');
			} /* to be reviewed */

			if($selected_nest)
			{
				if($selected_nest == 'box')
				{
					$compartments = \DB::table('relations')
							->join('boxes', 'relations.ref_id', '=', 'boxes.id')
							->where('type', '=', 'box')
							->select('relations.code', 'relations.id')
							->get();
				}

				if($selected_nest == 'surface')
				{
					$compartments = \DB::table('relations')
							->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
							->where('type', '=', 'surface')
							->select('relations.code', 'relations.id')
							->get();
				}

				if($selected_nest == 'room')
				{
					$compartments = \DB::table('relations')
							->join('rooms', 'relations.ref_id', '=', 'rooms.id')
							->where('type', '=', 'room')
							->select('relations.code', 'relations.id')
							->get();
				}
			}

			do
			{
				$generated_code = 'I' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
				$is_duplicate = in_array($generated_code, $codes_array);
			} 
			while($is_duplicate == TRUE);

			return View::make('inventory::create')->with('type', $type)
											->with('generated_code', $generated_code)
											->with('selected_nest', $selected_nest)
											->with('nests', $nests)
											->with('compartments', $compartments);	
		}
	}


	public function postCreate($type)
	{
		if($type == 'room')
		{
			$rules = array(
			'name'					=> 'required|unique:rooms');

			$validator = \Validator::make(\Input::all(), $rules);

			if($validator->passes())
			{
				$room = new Room;
				$room->name = \Input::get('name');
				$room->save();

				$date = new \DateTime;
				$room->relations()->insert(
					array(
						'code' => \Input::get('code'), 
						'type' => '5', 
						'ref_id' => $room->id,
						'parent_code' => 'FabLab',
						'created_at' => $date, 
						'updated_at' => $date
						)
					);

				if(\Input::get('next') != null)
				{
					\Session::forget('code');
					\Session::put('code', \Input::get('code'));

					return \Redirect::to('admin/inventory/create/cabinet')->with('success', 'Room has been created!');
				}
				else
				{
					return \Redirect::to('admin/inventory')->with('success', 'Room has been created!');
				}
			}
			else
			{
				return \Redirect::to('admin/inventory/create/room')->withInput()->withErrors($validator);
			}
		}

		if($type == 'cabinet')
		{
			$codes_array = Relation::lists('code');

			$rules = array(
			'columns'					=> 'numeric',
			'description'				=> 'max:72');

			$validator = \Validator::make(\Input::all(), $rules);

			if($validator->passes())
			{
				$cabinet = new Cabinet;
				$cabinet->columns = \Input::get('columns');
				$cabinet->description = \Input::get('description');
				$cabinet->save();

				$date = new \DateTime;

				for($i=0; $i<$cabinet->columns; $i++)
				{
					$surface = new Surface;
					$surface->column = $i;
					$surface->row = '0';
					$surface->description = 'Bottom of the cabinet';
					$surface->save();

					do
					{
						$generated_code = 'S' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
						$is_duplicate = in_array($generated_code, $codes_array);
					} 
					while($is_duplicate == TRUE);

					$surface->relations()->insert(
					array(
						'code' => $generated_code, 
						'type' => '3', 
						'ref_id' => $surface->id,
						'parent_code' => \Input::get('code'),
						'created_at' => $date, 
						'updated_at' => $date
						)
					);
				}

				$cabinet->relations()->insert(
					array(
						'code' => \Input::get('code'), 
						'type' => '4', 
						'ref_id' => $cabinet->id,
						'parent_code' => \Input::get('room'),
						'created_at' => $date, 
						'updated_at' => $date
						)
					);

				if(\Input::get('next') != null)
				{
					\Session::forget('code');
					\Session::put('code', \Input::get('code'));

					return \Redirect::to('admin/inventory/create/surface')->with('success', 'Cabinet has been created!');
				}
				else
				{
					return \Redirect::to('admin/inventory')->with('success', 'Cabinet has been created!');
				}
			}
			else
			{
				return \Redirect::to('admin/inventory/create/cabinet')->withInput()->withErrors($validator);
			}
		}

		if($type == 'surface')
		{
			$codes_array = Relation::lists('code');

			$target_column = \Input::get('column');
			
			$existing_surfaces = \DB::table('relations')
						->join('surfaces', 'relations.ref_id', '=', 'surfaces.id')
						->where('relations.parent_code', '=', \Input::get('cabinet'))
						->where('surfaces.column', '=', $target_column)
						->get();

			/* to be reviewed */

			$rules = array(
			'rows'					=> 'numeric');

			$validator = \Validator::make(\Input::all(), $rules);

			if($validator->passes())
			{
				$date = new \DateTime;
				$number_of_surfaces = \Input::get('rows');

				for($i=0; $i<$number_of_surfaces; $i++)
				{
					$surface = new Surface;
					$surface->column = \Input::get('column');
					$surface->row = count($existing_surfaces) + $i;
					$surface->description = \Input::get('description'.($i+1));
					$surface->save();

					do
					{
						$generated_code = 'S' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
						$is_duplicate = in_array($generated_code, $codes_array);
					} 
					while($is_duplicate == TRUE);

					$surface->relations()->insert(
					array(
						'code' => $generated_code, 
						'type' => '3', 
						'ref_id' => $surface->id,
						'parent_code' => \Input::get('cabinet'),
						'created_at' => $date, 
						'updated_at' => $date
						)
					);
				}

				if(\Input::get('next') != null)
				{
					\Session::forget('code');
					\Session::put('code', \Input::get('code'));

					return \Redirect::to('admin/inventory/create/box')->with('success', 'Surface has been created!');
				}
				else
				{
					return \Redirect::to('admin/inventory')->with('success', 'Surface(s) has been created!');	
				}	
			}
			else
			{
				return \Redirect::to('admin/inventory/create/surface')->withInput()->withErrors($validator);
			}
		}

		if($type == 'box')
		{
			$codes_array = Relation::lists('code');

			$rules = array(
			'boxes'					=> 'numeric');

			$validator = \Validator::make(\Input::all(), $rules);

			if($validator->passes())
			{
				$date = new \DateTime;
				$number_of_boxes = \Input::get('boxes');

				for($i=1; $i<=$number_of_boxes; $i++)
				{
					$box = new Box;
					$box->description = \Input::get('description'.$i);
					$box->save();

					do
					{
						$generated_code = 'B' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
						$is_duplicate = in_array($generated_code, $codes_array);
					} 
					while($is_duplicate == TRUE);

					$box->relations()->insert(
					array(
						'code' => $generated_code, 
						'type' => '2', 
						'ref_id' => $box->id,
						'parent_code' => \Input::get('surface'),
						'created_at' => $date, 
						'updated_at' => $date
						)
					);
				}

				if(\Input::get('next') != null)
				{
					\Session::forget('code');
					\Session::put('code', \Input::get('code'));

					return \Redirect::to('admin/inventory/create/item')->with('success', 'Box(es) has been created!');
				}
				else
				{
					return \Redirect::to('admin/inventory')->with('success', 'Box(es) has been created!');
				}
			}
			else
			{
				return \Redirect::to('admin/inventory/create/box')->withInput()->withErrors($validator);
			}	
		}
		
		if($type == 'item')
		{
			$rules = array(
			'name'					=> 'required|unique:items',
			'quantity'				=> 'numeric');

			$validator = \Validator::make(\Input::all(), $rules);

			if($validator->passes())
			{
				$item = new Item;
				$item->name = \Input::get('name');
				$item->quantity = \Input::get('quantity');
				$item->description = \Input::get('description');
				$item->save();

				if ( \Input::file('image') )
				{
					$file = \Input::file('image');
					$destinationPath = "images/items/";
					$extension = $file->getClientOriginalExtension();
					$filename = time() . $item->id . "." . $extension;
					\Input::file('image')->move($destinationPath, $filename);
					$item->image = $filename;
					$item->save();
				}

				$date = new \DateTime;
				$item->relations()->insert(
					array(
						'code' => \Input::get('code'), 
						'type' => '1', 
						'ref_id' => $item->id,
						'parent_code' => \Input::get('compartment'),
						'created_at' => $date, 
						'updated_at' => $date
						)
					);

				return \Redirect::to('admin/inventory')->with('success', 'Item(s) have been created!');
			}
			else
			{
				return \Redirect::to('admin/inventory/create/item')->withInput()->withErrors($validator);
			}	
		}
	}


	public function getCsvlink($type, $code)
	{
		$arrSelectFields = array('r.type', 'r.code', );
		$query = \DB::table('relations as r');
		$currentDate = date('m-d-Y');

		if($code == "0" && $type != null)
		{
			$query->select($arrSelectFields)->where('type', '=', $type);
			$headers = array(
				'Content-Type' => 'text/csv',
				'Content-Disposition' => 'attachment; filename="all-'. $type . '_' . $currentDate . '.csv"'
				);
		}
		else
		{
			$query->select($arrSelectFields)->where('code', '=', $code);
			$headers = array(
				'Content-Type' => 'text/csv',
				'Content-Disposition' => 'attachment; filename="'. $code . '_' . $currentDate . '.csv"'
				);
		}
		
		$data = $query->get(); // fetched data

		$arrColumns = array('type', 'code');
		$arrFirstRow = array('type', 'code');

		$options = array(
			'columns' => $arrColumns,
			'firstRow' => $arrFirstRow,
			'headers' => $headers,
			);

		$Files = new Files;

		return $Files->convertToCSV($data, $options);
	}


	// is this valid?
	public function grabdata($term)
	{
		$term = Input::get('term');
		$data = [
		'1' => 'Xiaofen',
		'2' => 'Dennis',
		'3' => 'Saiman',
		'4' => 'Raksmey'
		];

		$result = [];

		foreach($data as $username)
		{
			if(strpos(Str::lower($username), $term) !== false)
			{
				$result[] = $username;
			}
		}

		return Response::json($result);
	}


}