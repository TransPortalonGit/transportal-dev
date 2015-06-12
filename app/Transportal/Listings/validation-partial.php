<?php

// Wenn Bild schon vorher hochgeladen wurde (bei erneutem Validationserror)
if(Session::has('preuploadedFile')){

    // wenn Bild gelöscht
    if($input['image_deleted'] == 'true'){
        Session::forget('preuploadedFile');
    }
}

// Wenn bei einem Error ein Bild vorhanden ist, hochladen und Pfad an den View übergeben
if (! Listing::$errors->has('file'))
{
    if(Input::hasFile('file')){
        $file = Input::file('file');
        $filename = Listing::uploadTemporaryFile($file);
        Session::put('preuploadedFile', $filename);
    }
}
 