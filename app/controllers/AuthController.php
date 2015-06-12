<?php

class AuthController extends BaseController {

	/**
	 * Account login.
	 *
	 * @return View
	 */
	public function getLogin()
	{
		if (Sentry::check())
		{
			return Redirect::to('/home');
		}
		return View::make('site/account/login');
	}

	/**
	 * QR code scan.
	 *
	 * @return View
	 */
	public function getQrscan($value, $QRkey)
	{
		$users = \User::where('QRkey', '=', urldecode($QRkey))
							->first();

		//if(!$users || strpos($QRkey, 'http://') )
		if(!$users || strpos($QRkey, 'http://') )
		{
			return View::make('site/account/badqrscan'); 
		}		

		//if ($users->inlab === '0')
		if ($value == '1') 
		{
			$users->inlab = '1';
			$users->enteredlab_at = date("Y-m-d H:i:s");
			$users->save();
		}
		else 
		{
			$users->inlab = '0';
			$users->leftlab_at = date("Y-m-d H:i:s");
			$users->save();
		}

		return View::make('site/account/qrscan')->with('users', $users);
	}

	/**
	 * Account login form processing.
	 *
	 * @return Redirect
	 */
	public function postLogin()
	{
		// Declare the rules for the form validation
		$rules = array(
			'username' => 'required',
			'password' => 'required'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			try
			{
				// Try to log the user in
				if (Sentry::authenticate(Input::only('username', 'password'), Input::get('rememberme', 0)))
				{
					// Get the page we were before
                    $referer = $_SERVER['HTTP_REFERER']; //better use HTTP_REFERER to never get wrong URLs
					//$redirect = Session::get('loginRedirect', 'home');

					// Unset the page we were before from the session
					Session::forget('loginRedirect');

					// Redirect to the users page
					return Redirect::to($referer)->with('success', Lang::get('account/auth.messages.login.success'));
				}

				// Redirect to the login page
				return Redirect::to('account/login')->with('error', Lang::get('account/auth.messages.login.error'));
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				$error = 'account_not_found';
			}
			catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
			{
				$error = 'account_not_activated';
			}
			catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
			{
				$error = 'account_suspended';
			}
			catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
			{
				$error = 'account_banned';
			}

			// Redirect to the login page
			return Redirect::to('account/login')->with('error', Lang::get('account/auth.' . $error));
		}

		// Something went wrong
		return Redirect::to('account/login')->withInput()->withErrors($validator);
	}

	/**
	 * User account creation form page.
	 *
	 * The function's name is purposly set to gibberish
	 * @return View
	 */
	public function getRegister()
	{
		// Are we logged in?
		if (Sentry::check())
		{
			return Redirect::to('profile');
		}

		// Show the page
		return View::make('site/account/register');
	}

	public function getRegisterSuccess()
	{
		// Are we logged in?
		if (Sentry::check())
		{
			return Redirect::to('account');
		}

		// Show the page
		return View::make('site/account/register-success');
	}

	public function getActivateSuccess()
	{
		// Are we logged in?
		if (Sentry::check())
		{
			return Redirect::to('account');
		}

		// Show the page
		return View::make('site/account/activate-success');
	}


	/**
	 * User account creation form processing.
	 *
	 * @return Redirect
	 */
	public function postRegister()
	{
		// Declare the rules for the form validation
		$rules = array(
			'username'				=> 'required|unique:users',
			'first_name'            => 'required',
			'last_name'             => 'required',
			'email'                 => 'required|email|unique:users',
			'password'              => 'required|confirmed',
			'password_confirmation' => 'required'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Create the user and activate the user
			$user = Sentry::register(array(
				'username' => Input::get('username'),
				'title' 	 => Input::get('title'),
				'first_name' => Input::get('first_name'),
				'last_name'  => Input::get('last_name'),
				'email'      => Input::get('email'),
				'password'   => Input::get('password'),
				'company'   => Input::get('company'),
				'street'   => Input::get('street'),
				'zipcode'   => Input::get('zipcode'),
				'city'   => Input::get('city')
			));

			$user->profile_pic = "DefaultAvatar.png";

		// Generate QRkey image and save locally
		
			$size          = '150x150';
			$user->QRkey   = Input::get('username') . (string)rand(0000, 9999);
			$correction    = strtoupper('L');
			$encoding      = 'UTF-8';
			  
			$rootUrl = "https://chart.googleapis.com/chart?cht=qr&chs=$size&chl=$user->QRkey&choe=$encoding&chld=$correction";

			$rawImage = file_get_contents($rootUrl);
			file_put_contents("qr-pics/". $user->id .".png",$rawImage);
		

			// Data to be used on the email view
			$data = array(
				'user' => $user,
				'activationcode' => $user->getActivationCode()
			);

			// Send the activation code through email
			Mail::send('emails.welcome', $data, function($m) use ($user)
			{
				$m->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Welcome ' . $user->first_name)->attach("qr-pics/". $user->id .".png");
			});

			// Redirect to the register page
			return Redirect::to('account/register-success')->with('success', 'Account created with success!');
		}

		// Something went wrong
		return Redirect::to('account/register')->withInput()->withErrors($validator);
	}

	/**
	 * User account activation page.
	 *
	 * @param  integer  $userId
	 * @param  string   $actvationCode
	 * @return
	 */
	
	public function getActivate($userId = null, $activationCode = null)	{
		try
		{
			// Get the user we are trying to activate
			$user = Sentry::getUserProvider()->findById($userId);

			// Try to activate this user account
			if ($user->attemptActivation($activationCode))
			{
				return Redirect::to('account/activate-success');
			}

			// The activation failed.
			$error = 'Activation failed.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$error = 'User does not exist.';
		}
		catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
		{
			$error = 'account_already_activated';
		}

		return View::make('errors/activation')->with('error', $error);
	}
	

	/**
	 * Forgot password page.
	 *
	 * @return View
	 */
	public function getForgotPassword()
	{
		// Are we logged in?
		if (Sentry::check())
		{
			return Redirect::to('/home');
		}

		// Show the page
		return View::make('site/account/forgot-password');
	}

	/**
	 * Forgot password form processing page.
	 *
	 * @return Redirect
	 */
	public function postForgotPassword()
	{
		// Declare the rules for the validator
		$rules = array(
			'username' => 'required'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			try
			{
				// Get the user password recovery code
				$user = Sentry::getUserProvider()->findByLogin(Input::get('username'));

				// Data to be used on the email view
				$data = array(
					'user' => $user
				);

				// Send the activation code through email
				Mail::send('emails.forgot-password', $data, function($m) use ($user)
				{
					$m->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Account Password Recovery');
				});

				// Redirect to the login page
				return Redirect::to('account/forgot-password')->with('success', 'Password recovery email successfully sent.');
			}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				$error = 'User does not exist.';
			}

			// Redirect to the login page
			return Redirect::to('account/forgot-password')->withInput()->with('error', $error);
		}

		// Something went wrong
		return Redirect::to('account/forgot-password')->withInput()->withErrors($validator);
	}

	/**
	 * Forgot Password Confirmation page.
	 *
	 * @param  string
	 * @return View
	 */
	public function getForgotPasswordConfirmation($userId = null, $resetCode = null)
	{
		try
		{
			//
			$user = Sentry::getUserProvider()->findById($userId);

			//
			if( ! $user->checkResetPassword($resetCode))
			{
				//
				return Redirect::to('account/forgot-password')->with('error', 'Reset password code is invalid.');
			}
		}
		catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			// Redirect to the forgot password page
			return Redirect::to('account/forgot-password')->with('error', 'User does not exist.');
		}

		// Show the page
		return View::make('site/account/forgot-password-confirmation');
	}

	/**
	 * Forgot Password Confirmation form processing page.
	 *
	 * @param  string
	 * @return Redirect
	 */
	public function postForgotPasswordConfirmation($userId = null, $resetCode = null)
	{
		// Declare the rules for the form validation
		$rules = array(
			'password'              => 'required|confirmed',
			'password_confirmation' => 'required'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{


			// Redirect to the register page
			return Redirect::to('account/login')->with('success', 'Account activated with success!');
		}

		// Something went wrong
		return Redirect::to('account/forgot-password/' . $resetCode)->withInput()->withErrors($validator);
	}

	/**
	 * Logout page.
	 *
	 * @return Redirect
	 */
	public function getLogout()
	{
		// Log the user out
		Sentry::logout();

		// Redirect to the users page
		return Redirect::to('/')->with('success', 'You have successfully logged out!');
	}

}