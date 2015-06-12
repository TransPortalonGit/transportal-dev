<?php

class QuestionController extends \BaseController {

    protected $question;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }

	/**
	 * Display a question of the resource.
	 *
	 * @return Response
	 */
	public function index() {

        $input = Input::all();

        if(isset($input['sorting']) && $input['sorting'] == 'new'){
            $query = Question::descCreatedAt();
        }else{
            $query = Question::ascCreatedAt();
        }





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

        Input::flash();



        if(!empty($input)){

            // Search
            if(isset($input['q']) && !empty($input['q'])){
                $query->search($input['q']);
                //dd($query);
            }

            // Your Question
            if(isset($input['question-show']) && !empty($input['question-show'])){
                $question_show = $input['question-show'];
                if($question_show == 'all' || $question_show == 'yours'){
                    ($question_show == 'all') ? $query->all() : $query->yours();
                }
            }

            if(isset($tagarray)) {
                $query->tagfilter($tagarray);
            }
        }

        if ( isset($input['showAll']) ) {
            if ( $input['showAll'] == 0 )  {

                $questions = $query->paginate(5);

                return View::make('site.question.index')
                    ->with('tagsselect', $tagsselect)
                    ->with('questions', $questions);
            }
        }

        if( isset($_GET['project_id'])  ) {
            $id = $_GET['project_id']; //project_id that is passed from the project site
            $query->project($id); //Return all questions from this project
            $questions = $query->paginate(5);

            return View::make('site.question.index')
                ->with('tagsselect', $tagsselect)
                ->with('project_id', $id)
                ->with('questions', $questions);

        }



        $questions = $query->paginate(5);




        return View::make('site.question.index')
            ->with('tagsselect', $tagsselect)
            ->with('questions', $questions);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $tagsselect = Tag::tagsForSelect();
        return View::make('site.question.create')
            ->with('tagsselect', $tagsselect)
            ->with('project_id', $_GET['project_id']);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = Input::all();

        if( ! $this->question->isValid($input))
        {
            return Redirect::back()->withInput()->withErrors($this->question->errors);
        }

        $this->question->user_id = Sentry::getUser()->id;
        $this->question->project_id = $input['project_id'];

        $this->question->title = $input['title'];
        $this->question->description = $input['description'];

        $this->question->save();

        $a = $input['project_id'];

        $tags = Input::get('tags');
        if(!empty($tags)){
            foreach($tags AS $tag){
                $question_tag = new QuestionTag();
                $question_tag->question_id = $this->question->id;
                $question_tag->tag_id = $tag;
                $question_tag->save();
            }
        }

        return Redirect::action('ProjectController@show', $a);


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        // if $id = show the ID is passed in the Link and not as a parameter
        if ( $id == "show" ) {
            $id = $_GET['question_id'];
        }

        $question = Question::find($id);

        if( isset($_GET['from']) ) {
            $from = $_GET['from'];

            return View::make('site.question.show')
                ->with('from', $from)
                ->with('question', $question);
        }

	    return View::make('site.question.show')
            ->with('question', $question);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $question = Question::find($id);

        $selectedttags = $question->tags;

        $tagsselect = Tag::tagsForSelect($selectedttags);



        return View::make('site.question.edit')
            ->with('tagsselect', $tagsselect)
            ->withQuestion($question);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if(!Sentry::check()) return Redirect::to('/account/login');

        $question = Question::find($id);

        $input = Input::all();
        if( ! $this->question->isValid($input))
        {
            return Redirect::back()->withInput()->withErrors($this->question->errors);
        }

        $question->title = $input['title'];
        $question->description = $input['description'];


        $question->save();
        $tags = Input::get('tags');
        QuestionTag::where("question_id", $question->id)->delete();
        if(!empty($tags)){
            foreach($tags AS $tag){
                $question_tag = new QuestionTag();
                $question_tag->question_id = $question->id;
                $question_tag->tag_id = $tag;
                $question_tag->save();
            }
        }

        $question_id = $question->id;

        return Redirect::action('QuestionController@show', $question_id)
            ->with('notification', $question->getNotification('edit'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $from = Input::get('from');

        if(!Sentry::check()) return Redirect::to('/account/login');


        $question = Question::find($id);


        Answer::where('question_id', $id)->delete();
        QuestionTag::where('question_id', $id)->delete();

        $question->delete();

        $project_id = $question->project_id;

        $notification = $question->getNotification('delete');

        if (isset($from)) {
            if( $from == "index" ) {
                return Redirect::action('QuestionController@index')
                    ->with('notification', $notification);
            }
            if( $from == "profile" ) {
                return Redirect::to('/profile/questions')
                    ->with('notification', $notification);
            }
        }
        return Redirect::action('ProjectController@show', $project_id)
            ->with('notification', $notification);


	}

}