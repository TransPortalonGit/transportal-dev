<?php

class SecLabController extends BaseController {

	public function Respond($scanval){
		$view = View::make('securelab/Respond');
		$response = 'false';
		$date = new DateTime;
		$date->modify('-5 minutes');
		$formatted_date = $date->format('Y-m-d H:i:s');
		if($scanval != null){
			$dbQuery = DB::table('qrhash')->where('hash', $scanval)->first();			
				if($dbQuery != null){
					if($dbQuery->hash == $scanval){
						$response = 'true';
					}
				}
		}else{
			$response = 'no parameter';
		}
		$checkdate = DB::table('qrhash')->where('hash', $scanval)->where('created_at', "<=" , $formatted_date)->first();
		if($checkdate != null){
			$response = 'expired';
			//Delete expired
			//DB::table('qrhash')->where('hash', $scanval)->delete();
		}
		return $view->with('response', $response);
	}
	
	public function respondException($scanval, $scanval2){
		$view = View::make('securelab/Respond');
		$response = 'false';
		$scanval = $scanval . "/" . $scanval2;
			$dbQuery = DB::table('qrhash')->where('hash', $scanval)->first();			
				if($dbQuery != null){
					if($dbQuery->hash == $scanval){
						$response = 'true';
					}
				}
		$checkdate = DB::table('qrhash')->where('hash', $scanval)->where('created_at', "<=" , $formatted_date)->first();
		if($checkdate != null){
			$response = 'expired';
			//Delete expired
			//DB::table('qrhash')->where('hash', $scanval)->delete();
		}
		return $view->with('response', $response);
	}
	
	public function Generator()	{
		
		$machineList = DB::table('machines')->get();
				$permArray = array();
				foreach($machineList as $mi){
					$permArray = array_add($permArray, $mi->name, $mi->name);
				}
		if(!\Sentry::check()){
			return \Redirect::to('/account/login');
		}else{
			$currentuser = \Sentry::getUser();
			$postUserID = Input::get('userid');
			$postDevice = Input::get('device');
				if($postDevice == null && $postUserID == null){
						return View::make('securelab/Generator')
						->with('permArray' , $permArray)
						->with('currentuser', $currentuser)
						->with('postUserID', $postUserID)
						->with('postDevice', $postDevice);
				}else{	
						return View::make('securelab/Generator')
						->with('permArray' , $permArray)
						->with('currentuser', $currentuser)
						->with('postUserID', $postUserID)
						->with('postDevice', $postDevice);
				}
		}
		
		
	}


}

?>