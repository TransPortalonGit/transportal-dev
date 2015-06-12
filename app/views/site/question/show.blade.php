@extends('layouts.master')

@section('head')

<script type="text/javascript" src="/js/question_edit.js"></script>
<link rel="stylesheet" href="/css/show-question-answers.css">

@stop

@section('content')
@if (Session::has('notification'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('notification') }}</strong>
</div>
@endif

<?php $user = Sentry::getUser(); ?>

<div class="question">
    <?php $author = User::where('id', '=' , $question->user_id)->first(); ?>
    <?php $project = Project::where('id', '=' , $question->project_id)->first(); ?>

    @if ( Sentry::check() && $user->id  ==  $question->user_id )
    <a href="" id="delete-btn" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal-destroy-question" >Delete</a>
    <a href="{{ route('question.edit', $question->id) }}" id="edit-btn" class="btn btn-xs btn-warning">Edit</a>
    @endif
    <div class="text">
        <h2>
            {{$question->title}}
                <h3>
                    by <a href="/profile/show/{{$author->username}}">{{$author->username}}</a> in project: <a href="{{ route('project.show', $project->id) }}">{{$project->title}}</a>
                </h3>
        </h2>

        <div class="tagContainer"">
            <?php
                $questionTags = QuestionTag::where( 'question_id', '=', $question->id )->get();
                foreach($questionTags as $questionTag){
                    $tag = Tag::where('id', '=', $questionTag->tag_id )->first();
                    echo ( " <a href=\" /question?tags[]=$tag->id \">  <span class=\" btn-xs btn-info tag\"> $tag->tag </span> </a>");
                }
            ?>
        </div>

        <p>{{$question->description}}</p>
    </div>
</div>


<div class="modal fade" id="myModal-destroy-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to delete the question "{{ $question->title }}"?</h4>
            </div>

            <div style="width: 35%; margin: 30px auto 15px">
                <div style="float: right">
                    {{ Form::open(['method' => 'delete', 'route' => ['question.destroy', $question->id]]) }}
                    @if( isset($from) )
                    {{Form::hidden('from', $from)}}
                    @endif
                    {{ Form::submit('Delete Question', ['class' => 'btn btn-danger']) }}
                    {{ Form::close() }}
                </div>
                <div style="float:right; margin-right: 5px">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
</div>



<h4>Answers</h4>

<div class="answer">
    <?php $answers = Answer::where('question_id', '=' , $question->id)->get(); ?>

    @foreach ($answers as $answer)
    <div class="single-answer">

        @if ( Sentry::check() && $user->id  ==  $answer->user_id )
        <a href="" id="delete-btn" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#myModal-destroy-answer" >Delete</a>
        <a href="{{ route('answer.edit', $answer->id) }}" id="edit-btn" class="btn btn-xs btn-warning">Edit</a>
        @endif

        <?php $author = User::where('id', '=' , $answer->user_id)->first(); ?>
        <div class="text">
            <h4><a href="/profile/show/{{$author->username}}">{{$author->username}}</a></h4>
            <p>{{$answer->description}}</p>
        </div>

        <div class="modal fade" id="myModal-destroy-answer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Are you sure you want to delete the Answer?</h4>
                    </div>

                    <div style="width: 30%; margin: 30px auto 15px">
                        <div style="float: right">
                            {{ Form::open(['method' => 'delete', 'route' => ['answer.destroy', $answer->id]]) }}
                            {{ Form::submit('Delete Answer', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </div>
                        <div style="float:right; margin-right: 5px">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endforeach
</div>
<div>
    <h4>Your Answer</h4>
</div>


<div class="answer-form">
    <!--Begin Formular zum Antworten-->
    {{ Form::open(['class'=>'form-horizontal', 'role'=>'form', 'route' => 'answer.store', 'method' => 'post']) }}

    <div class="form-group required {{ $errors->first('description')? 'has-error':''; }}">
        <div class="col-sm-8 answer-form-controll">
            {{ Form::textarea('description', null, ['cols' => '67', 'rows' => '5', 'maxlength' => '2000', 'class' => 'form-control input-sm ' ]) }}
            {{ $errors->first('description', '<span class="label label-danger">:message</span>') }}
        </div>
        <span class="info-box">(max. 2000 characters)</span>
    </div>

    <input name="question_id" type="hidden" value="{{$question->id}}">


    <?php

    if(!Sentry::check())
    {
        echo("Log in to answer");
    }
    else
    {
        echo(Form::submit('Answer', ['class' => 'btn btn-success', 'id' => 'answer-btn']));
    }


    ?>


    {{ Form::close() }}
    <!--End Formular zum Antworten-->
</div>


@stop