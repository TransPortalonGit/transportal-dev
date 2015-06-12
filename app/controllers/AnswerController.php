<?php

class AnswerController extends \BaseController {

    protected $answer;



    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

	/**
	 * Display a question of the resource.
	 *
	 * @return Response
	 */
	public function index() {

    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        //
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = Input::all();

        if( ! $this->answer->isValid($input))
        {
            return Redirect::back()->withInput()->withErrors($this->answer->errors);
        }

        $this->answer->user_id = Sentry::getUser()->id;
        $this->answer->question_id = $input['question_id'];

        $this->answer->description = $input['description'];

        $this->answer->save();

        $question_id = $input['question_id'];
        $question = Question::where('id', '=' , $question_id)->first();
        $project = Project::where('id', '=' , $question->project_id)->first();
        $project_id = $project->id;

        return View::make('site.question.show')->with('question', $question);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	    //return View::make('site.listings.show')
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $answer = Answer::find($id);
        return View::make('site.answer.edit')->withAnswer($answer);
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

        $answer = Answer::find($id);

        $input = Input::all();
        if( ! $this->answer->isValid($input))
        {
            return Redirect::back()->withInput()->withErrors($this->answer->errors);
        }

        $answer->description = $input['description'];

        $answer->save();

        $question_id = $answer->question_id;

        return Redirect::action('QuestionController@show', $question_id)
            ->with('notification', $answer->getNotification('edit'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!Sentry::check()) return Redirect::to('/account/login');


        $answer = Answer::find($id);

        $answer->delete();


        $question_id = $answer->question_id;

        $notification = $answer->getNotification('delete');

        return Redirect::action('QuestionController@show', $question_id)
            ->with('notification', $notification);


    }

}