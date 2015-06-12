<?php

class Listing extends Eloquent {

    protected $table = 'listings';

    public  $timestamps = true;

    public static $rules = [
        'is_offer' => 'required|in:0,1',
        'is_service' => 'required|in:0,1',
        'title' => 'required|between:2,60',
        'description' => 'required|between:2,1023',
        'file' =>  'image|max:7168',
        'duration' => 'required|in:3,5,7,10,30'
    ];

    public static $errors;

    public $imagePath = 'uploads/listings/';
    public static $temporaryImagePath = 'uploads/listings/temporary/';

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function tags(){
        return $this->hasMany('ListingTag');
    }

    public function scopeActive($query){
        return $query->where('ends_at', '>', DB::raw('NOW()'));
    }

    public function scopeExpired($query){
        return $query->where('ends_at', '<=', DB::raw('NOW()'));
    }

    public function scopeSearch($query, $search){
        return $query->where('title', 'LIKE', "%$search%");
    }

    public function scopeMaterials($query)
    {
        return $query->where('is_service', '=', 0);
    }

    public function scopeServices($query)
    {
        return $query->where('is_service', '=', 1);
    }

    public function scopeOffers($query){
        return $query->where('is_offer', '=', 1);
    }

    public function scopeNeeds($query){
        return $query->where('is_offer', '=', 0);
    }

    public function scopeDescCreatedAt($query){
        return $query->orderBy('created_at', 'DESC');
    }

    public function scopeAscEndsAt($query){
        return $query->orderBy('ends_at');
    }

    public function scopeDescEndsAt($query){
        return $query->orderBy('ends_at', 'DESC');
    }

    public function scopeTagfilter($query, $array){

        $listingIds = array();
        $listingTags = ListingTag::whereIn('tag_id', $array)->get();
        foreach($listingTags as $listingTag){
            $listingIds[] = $listingTag->listing_id;
        }

        if($listingIds == null){
            return $query->whereIn('id', [0]);
        }else{
            return $query->whereIn('id', $listingIds);
        }
    }

    public function getType(){
        return $this->is_offer ? 'Offer' : 'Need';
    }

    public function getTypeOfService(){
        return $this->is_service ? 'Service' : 'Material';
    }

    public function isActive(){
        return strtotime($this->ends_at) - time() > 0;
    }

    public static function isValid($data)
    {
        $validation = Validator::make($data, static::$rules);

        if($validation->passes()) return true;

        static::$errors = $validation->messages();

        return false;
    }

    // Prüft, ob die neue Laufzeit bei einem bearbeiteten Listing valide ist
    public function newEndsAtIsValid($newDuration){
        $newEndsAt = $this->getNewEndsAt($newDuration);
        $newEndTime = strtotime($newEndsAt);
        $currentTime = time();

        return ($newEndTime <= $currentTime) ? false : true;
    }

    // Gibt einen Unix-Timestamp der neu
    public function getNewEndsAt($newDuration){
        $oldEndTime = strtotime($this->created_at);
        $newEndTime = strtotime('+' . $newDuration . ' days', $oldEndTime);
        $newEndsAt = date('Y-m-d H:i:s', $newEndTime);

        return $newEndsAt;
    }

    public function getDurationInDays(){
        $date1 = strtotime($this->created_at);
        $date2 = strtotime($this->ends_at);
        $datediff = $date2 - $date1;
        return floor($datediff/(60*60*24));
    }

    // Lädt die Datei hoch
    public function uploadFile($file){

        $extension = $file->getClientOriginalExtension();

        do{
            $filename = str_random(12) . '.' . $extension;
        }
        while(file_exists($this->imagePath . $filename));

        $file->move($this->imagePath, $filename);

        return $filename;
    }

    public static function uploadTemporaryFile($file){
        $extension = $file->getClientOriginalExtension();

        $path = Listing::$temporaryImagePath;
        $filename = Sentry::getUser()->id . '.' . $extension;
        $absolutePath = $path . $filename;

        if(file_exists($absolutePath)){
            File::delete($absolutePath);
        }

        $file->move($path, $filename);

        return $filename;
    }

    public function moveAndRename(){
        $oldFilename = Session::get('preuploadedFile');
        $parts = explode(".", $oldFilename);

        do{
            $filename = str_random(12) . '.' . $parts[1];
            $newPath = $this->imagePath . $filename;
        }
        while(file_exists($newPath));

        $oldPath = Listing::$temporaryImagePath . $oldFilename;
        rename($oldPath, $newPath);

        return $filename;
    }

    // Gibt die Restzeit für ein Listing zurück
    public function getTimeLeft(){
        $date1 = new DateTime(date("Y-m-d H:i:s"));
        $date2 = new DateTime($this->ends_at);

        $difference = $date1->diff($date2);

        $timeLeft = "";

        if($difference->m != 0) $timeLeft .= $difference->m . 'm';
        if($difference->d != 0) $timeLeft .= $difference->d . 'd ';
        if($difference->h != 0) $timeLeft .= $difference->h . 'h ';
        if($difference->m + $difference->d == 0) $timeLeft .= $difference->i . 'min ';
        if($difference->m + $difference->d + $difference->h == 0) $timeLeft .= $difference->s . 's ';

        return $timeLeft;
    }

    public function getEndedAt(){
        return date("d.m.y", strtotime($this->ends_at));
    }

    public function getImageToDisplay(){
        if($this->hasImage()){
            return $this->getImagePath();
        }else{
            return "/img/images.jpg";
        }
    }

    public function hasImage(){
        return ($this->image_path != null && $this->image_name != null) ? true : false;
    }

    public function getImagePath(){
        return '/' . $this->image_path . $this->image_name;
    }

    public function deleteImage(){
        File::delete($this->imagePath . $this->image_name);
        $this->image_path = null;
        $this->image_name = null;
    }

    public function getNotification($action){
        return 'You successfully ' . $action . ' the listing "' . $this->title . '"!';
    }

}