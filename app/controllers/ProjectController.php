<?php

class ProjectController extends BaseController {

    public function index()	{
        if(!Sentry::check())
        {
            return Redirect::to('/account/login');
        }
        else
        {
            $projects = Project::orderBy('updated_at', 'desc')
            ->with('user')
            -> where('user_id', '=', Sentry::getUser()->id)
            ->paginate(5);
        return View::make('site.project.index')->with('projects', $projects);
        }	

    }

	public function download($pid) {
		
		$project = Project::where('id', '=', $pid)->firstorfail();

		$docpaths = array();
		$docnames = array();
		$documents = array();
		foreach($project->projectsessions as $psession) {
            if(!empty($psession->docs)){
                array_push($docpaths, explode(',', $psession->docs));
                array_push($docnames, explode(',', $psession->docnames));
            }
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

		header('Content-disposition: attachment; filename=' . $project->title . '_files.zip');
		header('Content-type: application/zip');
		readfile($tmp_file);
		unlink($tmp_file);

	}

	public function create() {
		if(!Sentry::check())
        {
            return Redirect::to('/account/login');
        }
        else
        {
        	$userlist = User::select('id', 'username')->get();
        	$users = array();
        	$users_number = count($users);

        	for($i=0; $i<$users_number; $i++)
        	{
        		$users[] = $userlist[$i]->username;
        	}

            return View::make('site.project.create')
            			->with('users_number', $users_number)
            			->with('users', $users);
        }		
	}

	public function store()	{

		$validator = Project::validate(Input::all());

		if ($validator->fails()) {
	        return Redirect::back()
	        		->withErrors($validator)
	        		->withInput();
		}

		$project = new project;			
	    $project->title = trim(Input::get('title'));
	    $project->content = self::_cleanRTEHTML(Input::get('content'));
	    $project->user_id = Sentry::getUser()->id;
	    $project->save();

	    if( Input::file('imgInput') )
		{
			$thumbnail_img = Input::file('imgInput');
			
			$ext = File::extension($thumbnail_img->getClientOriginalName());
			$uid = time() . uniqid() . '.' . $ext;
			$imgthumb_link =  "/uploads/projects/" . $project->id . "/images/" . $uid;
			$thumbnail_img->move(public_path() . "/uploads/projects/" . $project->id . "/images", $uid);
			
			$project->files = $imgthumb_link;
			$project->save();
		}

	    $projectuser = new ProjectUser();
	    $projectuser->user_id = Sentry::getUser()->id;
	    $projectuser->manager = 1;
	    $projectuser->project()->associate($project);

		$projectuser->accept();

		if(Input::get('members'))
		{
			$project_members_ids = Input::get('members');

			for($i=0; $i<count($project_members_ids); $i++)
			{
				$projectuser = new ProjectUser();
			    $projectuser->user_id = $project_members_ids[$i];
			    $projectuser->manager = 0;
			    $projectuser->project()->associate($project);

				$projectuser->accept();
			}
		}
		
		return Redirect::to('/project/' . $project->id)->with('success', 'Project successfully saved!');
	}
	
	
	public function update($id = null)	{

		$project = Project::find($id);
		
		$validator = Project::validate(Input::all());

		if ($validator->fails()) {
	        return Redirect::to('/project/'. $id.'/edit')->withErrors($validator);
		}

		$project->title = trim(Input::get('title'));
        $project->content = self::_cleanRTEHTML(Input::get('content'));
        $project->user_id = Sentry::getUser()->id;

		$project->save();
				
		return Redirect::to('/project/' . $project->id)->with('success', 'Project successfully updated!');

	}

	public function favorite($id)
	{
		$user = Sentry::getUser();
		$project = Project::find($id);

		if(!$user) 
		{
			return View::make('site/account/login');
		} 
		else
		{

			$userfavorite = new Usersfavorite;
			$userfavorite->user_id = $user->id;
			$userfavorite->project_id = $project->id;
			$userfavorite->timestamp = new DateTime;
			$userfavorite->save();

			$project->favorite = $project->favorite+1;
			$project->save();

			return Redirect::back();
		}
	}

	public function unfavorite($id)
	{
		$currentuser = Sentry::getUser();
		$userfavorite = Usersfavorite::find($id);
		$project = Project::find($userfavorite->project_id);

		if(Sentry::check())
		{
			$project->favorite = $project->favorite-1;
			$project->save();

			$userfavorite->delete();

			return Redirect::back();
		}
	}

	
	public function show($id)	{

		
		$project = Project::find($id);
		$user = User::where('id', '=', $project->user_id)->firstorfail();
		$project->content = self::_cleanRTEHTML($project->content);
		$usersprojects = Project::where('user_id', '=', $user->id)->get();	
		$comments = DB::table('projects_comments')
						->join('users_comments', 'projects_comments.comment_id', '=', 'users_comments.id' )
						->join('users', 'users_comments.user_id', '=', 'users.id')
						->where('projects_comments.project_id', '=', $project->id)
						->select('users_comments.body', 'users_comments.created_at', 'users.profile_pic', 
							'projects_comments.up_votes', 'projects_comments.reply_id', 'users.username',
							'projects_comments.comment_id')
						->get();

		// Commenter index used in _commentbox.blade.php
		$index = 0;

		// The user who is currently logged in
		$currentuser = Sentry::getUser();

		// Load User's favorites table
		$userfavorite = \Usersfavorite::where('project_id', '=', $id)->get();

		// Check if the user favorites the specific project
		$userfavorite_id = 1;
		$projectfavorite = 0;

		for($i=0; $i<count($userfavorite); $i++)
		{
			if(Sentry::check())
			{
				if($userfavorite[$i]->user_id == $currentuser->id)
				{
					$userfavorite_id = $userfavorite[$i]->id;
					$projectfavorite = 1;
				}
			}
		}

		// Project stats - VIEWS
		if(!Sentry::getUser() || $currentuser->id != $user->id) {
			$project->views = $project->views + 1;
			$project->save();
		} 

		//Question data for partial
		$questions = Question::where('project_id', '=' , $id)->get();

        // Wanted data for partial
        $wanted['data'] = Wanted::where('project_id', '=', $id)->first();
        if($wanted['data'] !== NULL)
            $wanted['wanted_tags'] = WantedTag::where('wanted_id', '=', $wanted['data']->id)->get();
        $wanted['project'] = $project;

        $wanted['user'] = $currentuser;
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

        // Project Users
        $projectUsers = $project->projectUsers;
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
        $projectUsersData['project'] = $project;
        $projectUsersData['user'] = $currentuser;

        $wanted['projectUsersData'] = $projectUsersData;
		
	    return View::make('site.project.show')
	    	->with('project', $project)
	    	->with('usersprojects', $usersprojects)
	    	->with('user', $user)
	    	->nest('question', 'site.project.question', array('questions' => $questions, 'project_id' => $id, 'project' => $project))
            ->nest('projectUsers', 'site.project.projectUsers', $projectUsersData)
            ->nest('wanted', 'site.project.wanted', $wanted)
            ->with('wantedData', $wanted['data'])
            ->with('userfavorite_id', $userfavorite_id)
            ->with('currentuser', $currentuser)
            ->with('projectfavorite', $projectfavorite)
            ->with('comments', $comments)
            ->with('index', $index);
	}
	

	public function edit($id)	{
		$project = Project::findOrFail($id);
		$project->content = self::_cleanRTEHTML($project->content);

	    return View::make('site/project/edit', compact('project'))
	    	->with('project', $project);
	}
		
		
	public function destroy($id) {
		
		$project = Project::find($id);
		$project->projectSessions()->delete();
		$project->delete();


		
		File::deleteDirectory(public_path(). "/uploads/projects/" . $id);
		return Redirect::to('/profile/projects')->with('success', 'Project successfully deleted!');

	}


	public function postComment($id) {

		$comment = new Users_comment;
		$comment->user_id = Sentry::getUser()->id;
		$comment->body = Input::get("userComment");
		$comment->save();

		$save_to_pivot = $comment->pivot_projectscomments($id, $comment->id, "0");

		if($save_to_pivot == "ok")
		{
			return Redirect::back();
		}

	}


	public function postUserslist() {

		$mysql = new mysqli('localhost','root','kodin','transportal', 8889);
	    $result = $mysql->query("select * from users");
	    $rows = array();
	    
	    while($row = $result->fetch_array(MYSQL_ASSOC)) 
	    {
	        $rows[] = array_map("utf8_encode", $row);
	    }
	    
	    echo json_encode($rows);
	    
	    $result->close();
   		$mysql->close();

	}

	
	private function _cleanRTEHTML($string) {
		$pattern = ':<[^/>]*>\s*</[^>]*>:';
		$string = preg_replace($pattern, '', $string);
		$string = preg_replace(':style="(.*)":', '', $string);
		$string = preg_replace(':id="(.*)":', '', $string);
		return trim($string);
	}
	

}