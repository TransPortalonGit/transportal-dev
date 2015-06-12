<?php

class SearchController extends BaseController {

public function getUsernames()
{
		$term = Input::get('term');
		$users = User::all();
		$data = array();
		$result = [];

		for($i=0;$i<count($users);$i++)
		{
			array_push($data, $users[$i]->username);
		}

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
