<?php

class ProfileController extends BaseController {


	public function getIndex()	{
	    return Redirect::to('/');	    	
	}


	
	public function getShow($username) {

		$usersinlab = User::where('inlab', '=', 1)->get();
		$user = User::where('username', '=', $username)->firstOrFail();
		$projects = \Project::where('user_id', '=', $user->id)->get();

        $query = Listing::where('user_id', '=', $user->id)->active();

        $total = count(Listing::where('user_id', '=', $user->id)->active()->get());

        $input = Input::all();

        $usersfavorites = DB::table('users_favorites')
                        ->join('projects', 'users_favorites.project_id', '=', 'projects.id')
                        ->where('users_favorites.user_id', '=', $user->id)
                        ->orderBy('timestamp', 'desc')
                        ->get();

        $selected = null;
        if (isset($input['tags'])) {
            $tagarray = $input['tags'];
            $selected = array();

            foreach( $tagarray as $tags ) {
                $index = sizeof($selected);
                $selected[$index] = new stdClass();
                $selected[$index]->tag_id = $tags;
            }
        }
        $tagsselect = Tag::tagsForSelect($selected);

        // Tags
        if(isset($tagarray)) {
            $query->tagfilter($tagarray);
        }

        // Listing Type
        if(isset($input['listing-type']) && !empty($input['listing-type'])){
            $listingType = $input['listing-type'];
            if($listingType == 'offer' || $listingType == 'need'){
                ($listingType == 'offer') ? $query->offers() : $query->needs();
            }
        }

        // Type of Service
        if(isset($input['type-of-service']) && !empty($input['type-of-service'])){
            $typeOfService = $input['type-of-service'];
            if($typeOfService == 'material' || $typeOfService == 'service'){
                ($typeOfService == 'service') ? $query->services() : $query->materials();
            }
        }

        if(isset($input['sorting']) && $input['sorting'] == 'new'){
            $query->descCreatedAt();
        }else{
            $query->ascEndsAt();
        }

        $listings = $query->paginate(3);

        Input::flash();

		return View::make('site/profile/index')
			   	->with('user', $user)
			   	->with('username', $username)
			   	->with('projects', $projects)
			   	->with('usersinlab', $usersinlab)
                ->with('listings', $listings)
                ->with('total', $total)
                ->with('tagsselect', $tagsselect)
                ->with('usersfavorites', $usersfavorites);
	}
	
}