<?php
namespace Profile;
use View;

class PasswordController extends \BaseController {


	public function getIndex()	{
		
		if (!\Sentry::check()) return \Redirect::to('account/login') ;
	    
	    $user = \Sentry::getUser();

	    return View::make('site/profile/passwordchange/index')
			   	->with('user', $user);	  
			   	    	
	}

	public function postUpdate() {

		$id = \Input::get('_id');
		$user = \Sentry::findUserById($id);

		// Declare the rules for the form validation (same id excepted)
		$rules = array(
			'stored_username'		=> 'unique:users,username,'.$id,
			'stored_email'          => 'unique:users,email,'.$id,
			);

		// Validate the inputs
		$validator = \Validator::make(\Input::all(), $rules);
		
		// Check if the form validates with success
		if ($validator->passes())
		{
			
			$user->username = \Input::get('stored_username');
			$user->email = \Input::get('stored_email');
			$user->company = \Input::get('stored_company');
			$user->street = \Input::get('stored_street');
			$user->zipcode = \Input::get('stored_zipcode');
			$user->city = \Input::get('stored_city');
			$user->description = \Input::get('limitedtextarea');
			$user->homepage = \Input::get('stored_homepage');
			$user->facebook = \Input::get('stored_facebook');
			$user->googleplus = \Input::get('stored_googleplus');
			$user->github = \Input::get('stored_github');
			$user->academia = \Input::get('stored_academia');
			$user->xing = \Input::get('stored_xing');
			$user->linkedin = \Input::get('stored_linkedin');
			$user->threedplatform = \Input::get('stored_threedplatform');
			$user->twitter = \Input::get('stored_twitter');


			$user->save();

			// Redirect to the register page
			return \Redirect::to('profile/passwordchange')->with('success', 'User editted with success!');
		}



			// Something went wrong
			//return \Redirect::to('profile/passwordchange/' . $user->id)->withInput()->withErrors($validator);
	}	
}