

@section('question')


<script type="text/javascript" src="/js/question_edit.js"></script>
<link rel="stylesheet" href="/css/question-answers.css">

<div class="question">

    <?php

    if(!Sentry::check())
    {

    }
    else
    {
        $user = Sentry::getUser();
        $user_id = $user->id;
    }


    ?>
    <?php $counter = 0 ?>
    @foreach ($questions as $question)
    @if( $counter <= 2 )<!--Quick and Dirty Counter for displaying only 3 questions-->

    <?php $author = User::where('id', '=' , $question->user_id)->first(); ?>
    <?php $project = Project::where('id', '=' , $question->project_id)->first(); ?>


        <div class="single-question">
            <div class="text">
                <h2> by {{$author->username}} in project: {{$project->title}}</h2>
                <a href="/question/show?question_id={{ $question->id }}&from=project">
                    <h4>{{$question->title}}</h4>
                </a>
                <?php
                $string =$question->description;
                $string = substr($string,0,200).'...';
                ?>
                <p>{{$string}}</p>

            </div>
        </div>
    <?php $counter++ ?>
    @endif
    @endforeach
    @if (  Sentry::check())
    <a href="/question/create?project_id={{ $project_id }}"><button type="create" class="btn btn-success" id="ask-btn">Create Question</button></a>

    @endif
    @if( $counter > 2 )
    <a href="/question?project_id={{ $project_id }}"><button type="create" class="btn btn-success" id="ask-btn">See all Questions</button></a>
    @endif
</div>


@stop

