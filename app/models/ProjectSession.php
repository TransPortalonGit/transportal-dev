<?php

class ProjectSession extends Eloquent {
	protected $table = 'projectsessions';

	public function project() {
		return $this->belongsTo('Project');
	}

	public static function validate($input) {
		$messages = array(
		    'project_id.required' => 'Sorry, but we don\'t know which in project you want to create this workstep. Please go back to your project and start a new workstep from there again.',
		    'description.required' => 'Please try to write a few words about this step.'
		);
		$rules = array(
			'step' => array('required', 'min:5'),
			'description' => array('required', 'max:1000'),
			'project_id' => array('required'),
			'duration' => array('numeric'),
			'costs' => array('numeric'),
		);

		return Validator::make($input, $rules, $messages);
	}
}