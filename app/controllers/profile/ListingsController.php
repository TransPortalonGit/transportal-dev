<?php

namespace Profile;
use View;

class ListingsController extends \BaseController {

    public function get_index()	{

        if(!\Sentry::check()) return \Redirect::to('/account/login');

        $currentuser = \Sentry::getUser();
        $username = $currentuser->username;

        $active = \User::find($currentuser->id)->listings()->active();
        $expired = \User::find($currentuser->id)->listings()->expired();

        $activeSum = $active->count();
        $expiredSum = $expired->count();

        $input = \Input::all();

        // Aktiv oder abgelaufen
        if(isset($input['status']) && $input['status'] == 'expired'){
            $query = $expired;
            $isActive = false;
            $total = count(\User::find($currentuser->id)->listings()->expired()->get());
        }else{
            $query = $active;
            $isActive = true;
            $total = count(\User::find($currentuser->id)->listings()->active()->get());
        }

        $selected = null;
        if (isset($input['tags'])) {
            $tagarray = $input['tags'];
            $selected = array();

            foreach( $tagarray as $tags ) {
                $index = sizeof($selected);
                $selected[$index] = new \stdClass();
                $selected[$index]->tag_id = $tags;
            }
        }
        $tagsselect = \Tag::tagsForSelect($selected);

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

        // Sorting
        if($isActive){
            (isset($input['sorting']) && $input['sorting'] == 'new') ? $query->descCreatedAt() : $query->ascEndsAt();
        }else{
            (isset($input['sorting']) && $input['sorting'] == 'least-recent') ? $query->ascEndsAt() : $query->descEndsAt();
        }

        $listings = $query->paginate(10);

        \Input::flash();

        return View::make('site/profile/listings/index')
            ->with('user', \Sentry::getUser())
            ->with('username', $username)
            ->with('listings', $listings)
            ->with('activeSum', $activeSum)
            ->with('expiredSum', $expiredSum)
            ->with('isActive', $isActive)
            ->with('total', $total)
            ->with('tagsselect', $tagsselect);
    }
} 