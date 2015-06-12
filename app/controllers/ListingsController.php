<?php

class ListingsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

        $input = Input::all();

        $query = Listing::active();

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

        // Tags
        if(isset($tagarray)) {
            $query->tagfilter($tagarray);
        }

        // Search
        if(isset($input['q']) && !empty($input['q'])){
            $query->search($input['q']);
        }

        // Sorting
        if(isset($input['sorting']) && $input['sorting'] == 'new'){
            $query->descCreatedAt();
        }else{
            $query->ascEndsAt();
        }

        $listings = $query->paginate(15);

        Input::flash();

        return View::make('site.listings.index')->with('listings', $listings)->with('tagsselect', $tagsselect);

    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        // User ist nicht eingeloggt
        if(!Sentry::check()) return Redirect::to('/account/login');

        $tagsselect = Tag::tagsForSelect();
        return View::make('site.listings.create')->with('tagsselect', $tagsselect);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        // User ist nicht eingeloggt
        if(!Sentry::check()) return Redirect::to('/account/login');

        $input = Input::all();

        if( ! Listing::isValid($input))
        {
            // validation Partial
            include app_path() . '/Transportal/Listings/validation-partial.php';

            return Redirect::back()->withInput()->withErrors(Listing::$errors);
        }

        $listing = new Listing;

        $listing->user_id = Sentry::getUser()->id;
        $listing->is_offer = $input['is_offer'];
        $listing->is_service = $input['is_service'];
        $listing->title = $input['title'];
        $listing->description = $input['description'];

        // upload file partial
        include app_path() . '/Transportal/Listings/upload-partial.php';

        // Field: duration
        $currentTime = time();
        $endTime = strtotime('+' . $input['duration'] . ' days', $currentTime);
        $endsAt = date('Y-m-d H:i:s', $endTime);
        $listing->ends_at = $endsAt;

        $listing->save();

        $insertedId = $listing->id;

        // Tags in Tag Tabelle eintragen
        $tags = Input::get('tags');
        if(!empty($tags)){
            foreach($tags AS $tag){
                $listingTag = new ListingTag();
                $listingTag->listing_id = $insertedId;
                $listingTag->tag_id = $tag;
                $listingTag->save();
            }
        }

        Session::flash('success', $listing->getNotification('created'));

        return Redirect::to('/profile/listings/?sorting=new');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $listing = Listing::find($id);

        // Listing existiert nicht
        if($listing == null) return Redirect::route('fabboard.listings.index');

        $owner = (Sentry::check() && Sentry::getUser()->id == $listing->user_id) ? true : false;

        // 1. Listing existiert nicht
        // 2. Listing ist abgelaufen und User ist nicht der Inhaber
        if(!$listing->isActive() && !$owner){
            return Redirect::route('fabboard.listings.index');
        }

	    return View::make('site.listings.show')
            ->with('owner', $owner)
            ->with('listing', $listing);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        // User ist nicht eingeloggt
        if(!Sentry::check()) return Redirect::to('/account/login');

        $listing = Listing::find($id);

        // Listing existiert nicht ODER Listing ist abgelaufen ODER User ist nicht Ersteller des Listings
        if($listing == null || !$listing->isActive() || Sentry::getUser()->id != $listing->user_id) return Redirect::route('fabboard.listings.index');

        // Dauer des Listings in Tagen berechnen
        $listing->duration = $listing->getDurationInDays();

        // Tags
        $tagsselect = Tag::tagsForSelect();

        // Tags des Listings
        $tagsToSelect = $listing->tags()->get();

        // Tags taggen, die vorausgewählt werden sollen
        foreach ($tagsToSelect as $toSelect)
        {
            $tagsselect['selected'][$toSelect->tag_id] = true;
        }

        return View::make('site.listings.edit')->withListing($listing)->withTagsselect($tagsselect);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        // User ist nicht eingeloggt
        if(!Sentry::check()) return Redirect::to('/account/login');

        $listing = Listing::find($id);

        // Listing existiert nicht ODER Listing ist abgelaufen ODER User ist nicht Ersteller des Listings
        if($listing == null || !$listing->isActive() || Sentry::getUser()->id != $listing->user_id) return Redirect::route('fabboard.listings.index');

        $input = Input::all();

        // Wenn Listing nicht valide oder wenn neue Dauer nicht valide
        if( ! $listing->isValid($input) || ! $listing->newEndsAtIsValid($input['duration']))
        {
            // validation Partial
            include app_path() . '/Transportal/Listings/validation-partial.php';

            return Redirect::back()->withInput()->withErrors(Listing::$errors);
        }

        $listing->is_offer = $input['is_offer'];
        $listing->is_service = $input['is_service'];
        $listing->title = $input['title'];
        $listing->description = $input['description'];
        $listing->ends_at = $listing->getNewEndsAt($input['duration']);

        // wenn Bild gelöscht ODER neues hochgeladen ODER zwischengespeichertes Bild existiert
        if($input['image_deleted'] == 'true' || Input::hasFile('file') || Session::has('preuploadedFile')){
            // altes Bild löschen
            if($listing->hasImage()){
                $listing->deleteImage();
            }
        }

        // upload file partial
        include app_path() . '/Transportal/Listings/upload-partial.php';

        $listing->save();

        // alte Tags löschen
        $listing->tags()->delete();

        // Tags in Tag Tabelle eintragen
        $tags = Input::get('tags');
        if(!empty($tags)){
            foreach($tags AS $tag){
                $listingTag = new ListingTag();
                $listingTag->listing_id = $listing->id;
                $listingTag->tag_id = $tag;
                $listingTag->save();
            }
        }

        Session::flash('success', $listing->getNotification('edited'));

        return Redirect::to('/profile/listings');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        // User ist nicht eingeloggt
        if(!Sentry::check()) return Redirect::to('/account/login');

        $listing = Listing::find($id);

        // Listing existiert nicht ODER User ist nicht Ersteller des Listings
        if($listing == null || Sentry::getUser()->id != $listing->user_id) return Redirect::route('fabboard.listings.index');

        // Bild von Listing löschen, wenn eins existiert
        if($listing->hasImage()){
            $listing->deleteImage();
        }

        $notification = $listing->getNotification('delete');

        // Tags von dem Listing löschen
        $listing->tags()->delete();

        $listing->delete();

        Session::flash('success', $listing->getNotification('deleted'));

        return Redirect::to('/profile/listings');
	}

    /**
     * Show the form for relisting the specified, expired resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function relist($id){
        // User ist nicht eingeloggt
        if(!Sentry::check()) return Redirect::to('/account/login');

        $listing = Listing::find($id);

        // Listing existiert nicht ODER Listing ist aktiv ODER User ist nicht Ersteller des Listings
        if($listing == null || $listing->isActive() || Sentry::getUser()->id != $listing->user_id) return Redirect::route('fabboard.listings.index');

        // alte Dauer des Listings in Tagen berechnen
        $listing->duration = $listing->getDurationInDays();

        // Tags
        $tagsselect = Tag::tagsForSelect();

        // Tags des Listings
        $tagsToSelect = $listing->tags()->get();

        // Tags taggen, die vorausgewählt werden sollen
        foreach ($tagsToSelect as $toSelect)
        {
            $tagsselect['selected'][$toSelect->tag_id] = true;
        }

        return View::make('site.listings.relist')->withListing($listing)->withTagsselect($tagsselect);
    }

    /**
     * Store a relisted resource in storage.
     * @param  int  $id
     * @return Response
     */
    public function storeRelist($id){

        // User ist nicht eingeloggt
        if(!Sentry::check()) return Redirect::to('/account/login');

        $oldListing = Listing::find($id);

        // Listing existiert nicht ODER Listing ist aktiv ODER User ist nicht Ersteller des Listings
        if($oldListing == null || $oldListing->isActive() || Sentry::getUser()->id != $oldListing->user_id) return Redirect::route('fabboard.listings.index');

        $input = Input::all();

        if( ! Listing::isValid($input))
        {
            // validation Partial
            include app_path() . '/Transportal/Listings/validation-partial.php';

            return Redirect::back()->withInput()->withErrors(Listing::$errors);
        }

        // create listing
        $listing = new Listing;

        $listing->user_id = Sentry::getUser()->id;
        $listing->is_offer = $input['is_offer'];
        $listing->is_service = $input['is_service'];
        $listing->title = $input['title'];
        $listing->description = $input['description'];

        $deleteOld = false;
        if(Input::hasFile('file'))
        {
            $file = Input::file('file');
            $filename = $listing->uploadFile($file);

            $listing->image_name = $filename;
            $listing->image_path = $listing->imagePath;

            $deleteOld = true;

        }else if(Session::has('preuploadedFile')){

            if($input['image_deleted'] != 'true'){
                // move image and rename
                $newFileName = $listing->moveAndRename();

                // Image Name und Image Pfad in Datenbank eintragen
                $listing->image_name = $newFileName;
                $listing->image_path = $listing->imagePath;

            }
            Session::forget('preuploadedFile');

            $deleteOld = true;

        }else if($input['image_deleted'] == 'false'){
            // kein hochgeladenes Bild, kein zwischengespeichertes Bild, Bild nicht gelöscht = alte Daten verwenden
            $listing->image_name = $oldListing->image_name;
            $listing->image_path = $oldListing->imagePath;

        }else if($input['image_deleted'] == 'true'){
            // kein hochgeladenes Bild, kein zwischengespeichertes Bild, Bild gelöscht
            $deleteOld = true;
        }

        // Bild von altem Listing löschen, wenn eins existiert
        if($deleteOld && $oldListing->hasImage()){
            $oldListing->deleteImage();
        }

        //Tags vom alten Listing löschen
        $oldListing->tags()->delete();

        // altes Listing löschen
        $oldListing->delete();

        // Field: duration
        $currentTime = time();
        $endTime = strtotime('+' . $input['duration'] . ' days', $currentTime);
        $endsAt = date('Y-m-d H:i:s', $endTime);
        $listing->ends_at = $endsAt;

        $listing->save();

        $insertedId = $listing->id;

        // Tags in Tag Tabelle eintragen
        $tags = Input::get('tags');
        if(!empty($tags)){
            foreach($tags AS $tag){
                $listingTag = new ListingTag();
                $listingTag->listing_id = $insertedId;
                $listingTag->tag_id = $tag;
                $listingTag->save();
            }
        }

        Session::flash('success', $listing->getNotification('relisted'));

        return Redirect::to('/profile/listings/?sorting=new');
    }

    public function mails($id) {

        $listing = Listing::find($id);

        $contactEmail = Sentry::getUser()->email;
        $contactUser = Sentry::getUser()->username;
        //$input = Input::all();

        $content = Input::get('message');

        $listerMail = $listing->user->email;
        $lister = $listing->user->fullname();
        $data = array('email'=>$contactEmail, 'content'=>$content,
                      'contactUser'=> $contactUser, 'listing' => $listing, 'lister' => $lister, 'listermail' => $listerMail);

        Mail::queue('emails.listings', $data, function($m) use ($data)
        {
            $m->from($data['email'], 'Transportal User ' . $data['contactUser']);
            $m->to($data['listermail'], $data['lister'])
                ->subject($data['contactUser']. ' showed an interest in your listing: ' . $data['listing']->title);
        });

        // Session::flash('success', 'mail send!');
        return Redirect::back();
        //return Redirect::to('/fabboard/listings/$id');
    }

}