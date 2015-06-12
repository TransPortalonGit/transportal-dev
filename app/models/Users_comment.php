<?php

class Users_comment extends Eloquent  
{

	protected $table = 'users_comments';

	public  $timestamps = true;	

	public static function pivot_projectscomments($project_id, $comment_id, $reply_id) 
	{
		$commentproject = new Projects_comment;
		$commentproject->project_id = $project_id;
		$commentproject->comment_id = $comment_id;
		$commentproject->reply_id = $reply_id;
		$commentproject->up_votes = "0";
		$commentproject->save();

		return "ok";
	}

}