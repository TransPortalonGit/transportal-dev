<?php

namespace App\Modules\Users\Controllers\Admin;
use View;

class UserController extends \BaseController 
{

	public function getIndex()	
	{
		$sortby = \Input::get('sortby');
		$usrsperpage = \Input::get('usrsperpage');
		$users = \Sentry::paginate($usrsperpage);

		if(!$usrsperpage)
		{
			$usrsperpage = 10;
		} else {
			$users = \Sentry::paginate($usrsperpage);
		} 

		if($sortby) 
		{
			$users = \Sentry::orderBy($sortby, 'asc')->paginate($usrsperpage);
		}
	    
	    return View::make('users::index')
	    			->with('sortby', $sortby)
	    			->with('usrsperpage', $usrsperpage)
	    			->with('users', $users);
	}


	public function getAdd() 
	{
		return View::make('users::register');
	}


	public function getDelete($id, $username) 
	{
		// delete
		$user = \User::where('id', '=', $id)
						->where('username', '=', urldecode($username))
						->first();

		// redirect - also delete QR-Key image, projects and tutorials
		$user->projects()->delete();
		$user->tutorials()->delete();
		\File::delete(public_path(). '/qr-pics/' . $id . '.png');
		\File::deleteDirectory(public_path(). '/uploads/projects/' . $id);
		\File::deleteDirectory(public_path(). '/uploads/tutorials/' . $id);					
		$result = $user->delete();
		if($result) {
			return \Redirect::to('/admin/users')->with('success', $username . ' successfully deleted');
		}	else {
			return \Redirect::to('/admin/users')->with('error', $username . ' could not be deleted');
		}
	}


	public function getEdit($id) {
		$machines = \DB::table('machines')->get();
		$user = \Sentry::findUserById($id);
		return View::make('users::edit')
						->with('user', $user)
						->with('machines', $machines); //machines hinzugefügt
	}
	

	public function getView($id) {
		$user = \Sentry::findUserById($id);
		//$users = \User::find($id);
		return View::make('users::view')->with('user', $user);
	}


	public function getActivate($id) {
		$users = \User::find($id);
		$users->activated = '1';
		$users->save();
		return \Redirect::to('/admin/users');
	}


	public function postUpdate() 
	{
		
		$id = \Input::get('_id');
		$user = \Sentry::findUserById($id);

		// Declare the rules for the form validation (same id excepted)
		$rules = array(
			'username'				=> 'required|unique:users,username,'.$id,
			'first_name'            => 'required',
			'last_name'             => 'required',
			'email'                 => 'required|unique:users,email,'.$id,
			'Role'					=> 'required'
			);

		// Validate the inputs
		$validator = \Validator::make(\Input::all(), $rules);

		if(\Input::get('Role') == 1)
			{
				$adminGroup = \Sentry::findGroupById(1);
				$user->addGroup($adminGroup);
			}

		if(\Input::get('Role') == 2)
			{
				$adminGroup = \Sentry::findGroupById(1);
				$user->removeGroup($adminGroup);
			}
		
		// Check if the form validates with success
		if ($validator->passes())
		{
			
			$user->username = \Input::get('username');
			$user->title = \Input::get('title');
			$user->first_name = \Input::get('first_name');
			$user->last_name = \Input::get('last_name');
			$user->email = \Input::get('email');
			$user->company = \Input::get('company');
			$user->street = \Input::get('street');
			$user->zipcode = \Input::get('zipcode');
			$user->city = \Input::get('city');
			$user->Role = \Input::get('Role');
			//SecLab Edit
				$machineList = \DB::table('machines')->get();
				$permArray = array();
				foreach($machineList as $mi){
				$permArray = array_add($permArray, $mi->type, \Input::get($mi->type));
				}
			$user->permissions = $permArray;
			//End Edit
			$user->save();

			// Redirect to the register page
			return \Redirect::to('admin/users')->with('success', 'User editted with success!');
		}



			// Something went wrong
			return \Redirect::to('admin/users/edit/' . $user->id)->withInput()->withErrors($validator);
	}	


	public function postCreate()
	{

		// Declare the rules for the form validation
		$rules = array(
			'username'				=> 'required|unique:users',
			'first_name'            => 'required',
			'last_name'             => 'required',
			'email'                 => 'required|email|unique:users',
			'password'              => 'required|confirmed',
			'password_confirmation' => 'required',
			'QRkey'				    => 'required'
		);

		// Validate the inputs
		$validator = \Validator::make(\Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Create the user and activate the user
			$user = \Sentry::register(array(
				'username' => \Input::get('username'),
				'title' 	 => \Input::get('title'),
				'first_name' => \Input::get('first_name'),
				'last_name'  => \Input::get('last_name'),
				'email'      => \Input::get('email'),
				'password'   => \Input::get('password'),
				'company'   => \Input::get('company'),
				'street'   => \Input::get('street'),
				'zipcode'   => \Input::get('zipcode'),
				'city'   => \Input::get('city'),
				'QRkey' => \Input::get('QRkey'),
				'Role' => \Input::get('Role')
			));

			$user->permissions = array('3d_printer'=> \Input::get('p_3dprinter'), 'lasercutter'=> \Input::get('p_lasercutter'));
			$user->profile_pic = "DefaultAvatar.png";

			if(\Input::get('Role') == 1)
			{
				$adminGroup = \Sentry::findGroupById(1);
				$user->addGroup($adminGroup);
			}


			// Generate QRkey image and save locally
			if(isset($_REQUEST['QRkey']))
			{
				$size          = '150x150';
				$user->QRkey   = $_REQUEST['QRkey'];
				$correction    = strtoupper('L');
				$encoding      = 'UTF-8';
				  
				$rootUrl = "https://chart.googleapis.com/chart?cht=qr&chs=$size&chl=$user->QRkey&choe=$encoding&chld=$correction";

				$rawImage = file_get_contents($rootUrl);
				file_put_contents("qr-pics/". $user->id .".png",$rawImage);
			}

			// Data to be used on the email view
			$data = array(
				'user' => $user,
				'activationcode' => $user->getActivationCode()
			);

			// Send the credentials and activation link through email
			\Mail::send('emails.welcome', $data, function($m) use ($user)
			{
				$m->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Welcome ' . $user->first_name)->attach("qr-pics/". $user->id .".png");
			});

			// Redirect to the register page
			return \Redirect::to('admin/users')->with('success', 'Account created with success!');
		}

			// Something went wrong
			return \Redirect::to('admin/users/add')->withInput()->withErrors($validator);
	}

}