<?php

namespace Explore;
use View;

class TutorialController extends \BaseController {

	public function getIndex()	{
		$tutorials = \Tutorial::orderBy('created_at', 'desc')
			->with('user')
			->paginate(25);
	    return View::make('site/explore/tutorials/index')->with('tutorials', $tutorials);
	}

	public function getCreate()	{

		if(!Sentry::check()) 
		{
			return Redirect::to('/account/login');
		} 
		else 
		{
    	return View::make('site/explore/tutorials/create');
    	}
	}

	public function getShow($id)	{
		$tutorial = \Tutorial::with('user')->find($id);
		$tutorial->content = self::_cleanRTEHTML($tutorial->content);
		
		$steps = explode('<h2>', $tutorial->content);
		array_walk($steps, function(&$value){ $value = "<h2>" . $value ;} );

		$headings = self::_getTextBetweenTags($tutorial->content, 'h2'); 
		$tutorial->content = '';
		
		array_shift($steps);
	    return View::make('site/tutorial/show')
	    	->with('tutorial', $tutorial)
	    	->with('steps', $steps)
	    	->with('headings', $headings)
	    	;
	}

	public function getEdit($id)	{
		$tutorial = \Tutorial::find($id);
		$tutorial->content = self::_cleanRTEHTML($tutorial->content);

	    return View::make('site/tutorial/create')
	    	->with('tutorial', $tutorial);
	}
	
		
	public function postImageupload() {

		$file = Input::file('file');

		$ext = File::extension($file->getClientOriginalName());
		$uid = time().uniqid().'.'.$ext;
		
		$file->move(public_path().'/uploads/tmp',$uid);

		$array = array(
			'filelink' => '/uploads/tmp/'.$uid,
			'filename' => $file->getClientOriginalName()
		);
		
		echo stripslashes(json_encode($array));

	}
	
	public function getGetjson() {
		
		$existing_images = File::files(public_path()."/uploads/tutorials/35/images");

		return Response::json('[{ "thumb": "/uploads/tutorials/35/images/137035743451adfebad6dba.png", "image": "/uploads/tutorials/35/images/137035743451adfebad6dba.png", "title": "Image 1", "folder": "Folder 1" },]');
	}
	
	public function postEdit() {
		$id = Input::get('_id');
		$content = self::_cleanRTEHTML(Input::get('content'));
		$content = self::_saveRTEImages($content, $id);
				
		$tutorial = \Tutorial::find($id);
	    $tutorial->title = trim(Input::get('title'));
	    $tutorial->description = trim(Input::get('description'));
	    $tutorial->content = $content;
		$tutorial->save();	
		
		return Redirect::to('/tutorials/show/' . $tutorial->id)->with('success', 'Tutorial successfully updated!');
		
	}
	


	public function postCreate()	{
	
		$rules = array(
			'title' => array('required', 'min:10'),
			'description' => array('required', 'min: 25'),
		);
		
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
	        return Redirect::to('/tutorials/create')->withErrors($validator);
		}
		
		$tutorial = new tutorial;			
	    $tutorial->title = trim(Input::get('title'));
	    $tutorial->description = trim(Input::get('description'));
	    $tutorial->content = self::_cleanRTEHTML(Input::get('content'));
	    $tutorial->user_id = Sentry::getUser()->id;
		$tutorial->save();	

	    $tutorial->content = self::_saveRTEImages($tutorial->content, $tutorial->id);
		$tutorial->save();	
		
		return Redirect::to('/tutorials/show/' . $tutorial->id)->with('success', 'Tutorial successfully saved!');
	}
	
	public function postDelete() {
		$id = Input::get('_id');

		$tutorial = \Tutorial::find($id);
		$tutorial->delete();
		
		File::deleteDirectory(public_path(). "/uploads/tutorials/" . $id);
		return Redirect::to('/tutorials')->with('success', 'Tutorial successfully deleted!');
	}



//----------- PRIVATE FUNCTIONS -------------------//

	private function _cleanRTEHTML($string) {
		$pattern = ':<[^/>]*>\s*</[^>]*>:';
		$string = preg_replace($pattern, '', $string);
		$string = preg_replace(':style="(.*)":', '', $string);
		$string = preg_replace(':id="(.*)":', '', $string);
		return trim($string);
	}


	private function _getImagesByTagName($string){
	    $d = new DOMDocument();
	    $d->loadHTML('<?xml encoding="UTF-8">'. $string);
	    $return = array();
	    foreach($d->getElementsByTagName('img') as $item){
	        $return[] = $item->getAttribute('src');
	    }
	    return $return;
	}

	private function _getTextBetweenTags($string, $tagname){
	    $d = new DOMDocument();
	    $d->loadHTML('<?xml encoding="UTF-8">'. $string);
	    $return = array();
	    foreach($d->getElementsByTagName($tagname) as $item){
	        $return[] = $item->textContent;
	    }
	    return $return;
	}
	
	private function _saveRTEImages($content, $id) {
		$images = self::_getImagesByTagName($content); 
		
		$new_folder = "/uploads/tutorials/" . $id;
		$new_imagefolder = $new_folder . "/images";
		
		if (!file_exists(public_path().$new_folder)) {
			mkdir(public_path().$new_folder);
		}
		if (!file_exists(public_path().$new_imagefolder)) {
			mkdir(public_path().$new_imagefolder);
		}
		
		$existing_images = File::files(public_path().$new_imagefolder);
		
		$content_images = array();
		foreach($images as $image) {
			array_push($content_images, public_path().$image);
			$new_filename = str_replace('/uploads/tmp/', $new_imagefolder . '/', $image);
			File::move(public_path().$image, public_path().$new_filename);
		}
		
		// COMPARE IMAGES IN FOLDER AND CONTENT
		$new_existing_images = File::files(public_path().$new_imagefolder);
		$missing_images = array_diff($existing_images, $content_images);
		
		foreach ($missing_images as $missing_image) {
			File::delete($missing_image);
		}
		
		$content = str_replace('/uploads/tmp/', $new_imagefolder . "/" , $content);
		return $content;
	}

	private function _stringStartsWith($haystack, $needle) {
		return substr($haystack, 0, strlen($needle)) === $needle;
	}


}