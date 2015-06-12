<?php

if(Input::hasFile('file'))
{
    $file = Input::file('file');
    $filename = $listing->uploadFile($file);

    $listing->image_name = $filename;
    $listing->image_path = $listing->imagePath;
}else if(Session::has('preuploadedFile')){

    if($input['image_deleted'] != 'true'){
        // move image and rename
        $newFileName = $listing->moveAndRename();

        // Image Name und Image Pfad in Datenbank eintragen
        $listing->image_name = $newFileName;
        $listing->image_path = $listing->imagePath;

    }
    Session::forget('preuploadedFile');
}