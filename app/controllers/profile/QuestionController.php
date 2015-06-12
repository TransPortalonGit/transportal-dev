<?php
namespace Profile;
use View;
class QuestionController extends \BaseController {

    public function get_index()	{

        if(!\Sentry::check()) return \Redirect::to('/account/login');

        $currentuser = \Sentry::getUser();
        $username = $currentuser->username;
        $id = $currentuser->id;

        // Alle Questions des Users
        $query = \User::find($currentuser->id)->questions();

        $questions = $query->paginate(5);

        return View::make('site/profile/questions/index')
            ->with(array('user' => $currentuser, 'username' => $username))
            ->nest('question', 'site.profile.questions.question', array('questions' => $questions, 'user_id' => $id));
    }

}