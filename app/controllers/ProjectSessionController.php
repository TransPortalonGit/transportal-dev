<?php

class ProjectSessionController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        $projectSession;

        return View::make('site/projectsession/index');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(!Sentry::check())
        {
            return Redirect::to('/account/login');
        }
        else
        {
             if (Session::has('project_id')) {
		    	$project_id = Session::get('project_id');
		    } else {
		    	$project_id = null;
		    }
	    return View::make('site.projectsession.create')
	    	->with('project_id', $project_id);
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = ProjectSession::validate(Input::all());

		if ($validator->fails()) {
	        return Redirect::back()
	        		->withErrors($validator)
	        		->withInput();
		}
		
		$projectsession = new projectsession;		
	    $projectsession->step = trim(Input::get('step'));
	    $projectsession->duration = trim(Input::get('duration'));
	    $projectsession->technology = trim(Input::get('technology'));
	    $projectsession->material = trim(Input::get('material'));
	    $projectsession->costs = trim(Input::get('costs'));
	    $projectsession->description = self::_cleanRTEHTML(Input::get('description'));
	    $projectsession->project_id = trim(Input::get('project_id'));
		$projectsession->save();	
	
		$id = $projectsession->id;
		
		$base_folder = "/uploads/projects/".$projectsession->project_id."/".$id;
		$image_folder = $base_folder . "/images";
		$file_folder = $base_folder . "/files";
		$thumbnail_folder = $base_folder . "/thumbnail";

		$folders = array(
			public_path() . $base_folder,
			public_path() . $image_folder,
			public_path() . $file_folder,
			public_path() . $thumbnail_folder
		);
		
		foreach ($folders as $folder) {
			if (!file_exists($folder)) mkdir($folder, 0777, true);
		}

		// The "files" correspond to images and the "docs" to files.

		// Images
		$files_uploaded = array();
		$files_json = "";
		
		if ( Input::file('file') ) {
			$files = Input::file('file');
			foreach ($files as $file) {
				if (!empty($file)) {
					$ext = File::extension($file->getClientOriginalName());
					$uid = time() . uniqid() . '.' . $ext;
					$file_link = $image_folder . "/" . $uid;
					$file->move(public_path() . $image_folder, $uid);
					array_push($files_uploaded,  $file_link);
				}
			}
		}

		$files_json = (Input::file('file')) ? implode(',', $files_uploaded) : '';
		$projectsession->files = $files_json;

		// Files - PATH and NAMES
		$docs_uploaded = array();
		$docs_json = "";
		$docs_names = array();
		$docs_json_names = "";
		
		if ( Input::file('doc') ) {
			$docs = Input::file('doc');
			foreach ($docs as $doc) {
				if (!empty($doc)) {
					$ext = File::extension($doc->getClientOriginalName());
					$name = $doc->getClientOriginalName();
					$uid = time() . uniqid() . '.' . $ext;
					$doc_link = $file_folder . "/" . $uid;
					$doc->move(public_path() . $file_folder, $uid);
					array_push($docs_uploaded,  $doc_link);
					array_push($docs_names, $name);
				}
			}
		}

		$docs_json_names = (Input::file('doc')) ? implode(',', $docs_names) : '';
		$docs_json = (Input::file('doc')) ? implode(',', $docs_uploaded) : '';
		$projectsession->docs = $docs_json;
		$projectsession->docnames = $docs_json_names;
		
		// Save
		$projectsession->save();
		
		return Redirect::to('/projectsession/' . $id)->with('success', 'Projectsession successfully saved!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$projectsession = ProjectSession::find($id);
		$user = User::where('id', '=', $projectsession->project->user_id)->firstorfail();
		$projectsession->description = self::_cleanRTEHTML($projectsession->description);

		// Project Users
        $projectUsers = $projectsession->project->projectUsers;
        $accepted = '';
        $applied = 0;
        foreach($projectUsers AS $projectUser){
            $projectUser->user;
            if($projectUser->accepted_at !== '0000-00-00 00:00:00'){
                $accepted .= '<a href="/profile/show/'.$projectUser->user->username.'">'.$projectUser->user->username.'</a>, ';
            }else{
                $applied++;
            }
            $wanted['project_users'][] = $projectUser->user_id;
        }
        $accepted = rtrim($accepted, ', ');
        $projectUsersData['projectUsers'] = $projectUsers;
        $projectUsersData['projectUsersAccepted'] = $accepted;
        $projectUsersData['projectUsersApplied'] = $applied;
        $projectUsersData['project'] = $projectsession->project;
        $projectUsersData['user'] = Sentry::getUser();

        // Wanted data for partial
        $wanted['data'] = Wanted::where('project_id', '=', $id)->first();
        if($wanted['data'] !== NULL)
            $wanted['wanted_tags'] = WantedTag::where('wanted_id', '=', $wanted['data']->id)->get();
        $wanted['project'] = $projectsession->project;

        $wanted['user'] = Sentry::getUser();
        $tags = Tag::all();
        $tags_array = array();
        foreach($tags AS $tag){
            if($tag->parent !== NULL){
                $tags_array[$tag->parent]['tags'][$tag->id] = $tag->tag;
            }else{
                $tags_array[$tag->id]['parent'] = $tag->tag;
            }
        }
        $wanted['tags'] = $tags_array;

		return View::make('site.projectsession.show')
	    	->with('projectsession', $projectsession)
	    	->with('user', $user)
	    	->nest('projectUsers', 'site.project.projectUsers', $projectUsersData)
            ->nest('wanted', 'site.project.wanted', $wanted);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$projectsession = ProjectSession::findOrFail($id);
		$projectsession->content = self::_cleanRTEHTML($projectsession->content);

	    return View::make('site/projectsession/edit', compact('projectsession'))
	    	->with('projectsession', $projectsession);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
		$projectsession = ProjectSession::find($id);
		
		$validator = ProjectSession::validate(Input::all());


		if ($validator->fails()) {
	        return Redirect::to('/projectsession/'. $id.'/edit')->withErrors($validator)->withInput();
		}

		$base_folder = "/uploads/projects/" . $projectsession->project->id.'/'.$id;
		$image_folder = $base_folder . "/images";

		$folders = array(
			public_path() . $base_folder,
			public_path() . $image_folder
		);
		
		foreach ($folders as $folder) {
			if (!file_exists($folder)) mkdir($folder, 0755, true);
		}
		
		$files_project = array();
		$files_project = explode(',', $projectsession->files);
		$files_uploaded = array();
		$files_existing = (Input::get('existing_file') ) ? Input::get('existing_file') : array();
		$files_merged = array();
		$files_json = "";
		
		if ( Input::file('file') ) {
			$files = Input::file('file');
			foreach ($files as $file) {
				if (!empty($file)) {
					$ext = File::extension($file->getClientOriginalName());
					$uid = time() . uniqid() . '.' . $ext;
					$file_link = $image_folder . "/" . $uid;
					$file->move(public_path() . $image_folder, $uid);
					array_push($files_uploaded,  $file_link);
				}
			}
		}
		
		if (!empty($files_project) )	{			
			$files_existing_removed = array_diff($files_project, $files_existing);
			foreach ($files_existing_removed as $file_existing_removed) {
				File::delete(public_path() . $file_existing_removed);
			}
		}
		
		$files_project = $files_existing;

		if (!empty($files_project) && !empty($files_uploaded)) {
			$files_merged = array_merge( $files_project, $files_uploaded );
		} else if (!empty($files_project)) {
			$files_merged = $files_project;
		} else if (!empty($files_uploaded)) {
			$files_merged = $files_uploaded;
		}

		$files_json = ($files_merged != "") ? implode(',', $files_merged) : '';
		$projectsession->files = $files_json;

 		$projectsession->step = trim(Input::get('step'));
	    $projectsession->duration = trim(Input::get('duration'));
	    $projectsession->technology = trim(Input::get('technology'));
	    $projectsession->material = trim(Input::get('material'));
	    $projectsession->costs = trim(Input::get('costs'));
	    $projectsession->description = self::_cleanRTEHTML(Input::get('description'));
	   		

		$projectsession->save();

		return Redirect::to('/project/' . $projectsession->project->id)->with('success', 'Project successfully updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$projectsession = ProjectSession::find($id);
		$id = $projectsession->project->id;
		$projectsession->delete();

		File::deleteDirectory(public_path(). "/uploads/projects/".$id."/".$projectsession->id);
		return Redirect::to('/project/'.$id)->with('success', 'Session successfully deleted!');

	}

	public function download($id) {
		
		$projectsession = ProjectSession::where('id', '=', $id)->firstorfail();

		$docpaths = array();
		$docnames = array();
		$documents = array();
        if(!empty($projectsession->docs)){
            array_push($docpaths, explode(',', $projectsession->docs));
            array_push($docnames, explode(',', $projectsession->docnames));
        }
		

		$i = 0;
        foreach($docpaths as $docpath)  {
            $j = 0;
            foreach($docpath as $dp)  {      
                array_push($documents, [$docpaths[$i][$j], $docnames[$i][$j]]);
             	$j++;
            }
            $i++;
        }  

		
		$zip = new ZipArchive();

		$tmp_file = tempnam('.','');
		$zip->open($tmp_file, ZipArchive::CREATE);
		
		# loop through each file
		foreach($documents as $document) {
		   
		   	# add it to the zip
		    $zip->addFromString($document[1], file_get_contents('./'.$document[0]));

		}
		
		$zip->close();

		header('Content-disposition: attachment; filename=' . $projectsession->step . '_files.zip');
		header('Content-type: application/zip');
		readfile($tmp_file);
		unlink($tmp_file);

	}

	private function _cleanRTEHTML($string) {
		$pattern = ':<[^/>]*>\s*</[^>]*>:';
		$string = preg_replace($pattern, '', $string);
		$string = preg_replace(':style="(.*)":', '', $string);
		$string = preg_replace(':id="(.*)":', '', $string);
		return trim($string);
	}

}