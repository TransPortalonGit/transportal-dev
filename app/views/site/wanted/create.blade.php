@extends('layouts.master')


@section('content')
<h4>Create Wanted for '<a href="/project/{{ $project->id }}">{{ $project->title }}</a>'</h4>
<hr>
<div id="create-wanted">
    @if($errors->has())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    {{ Form::open(array('action' => 'WantedController@store')) }}
    @include('site.wanted.form')
    <div class="row margin-top-15">
        <div class="col-lg-2">
            <button type="submit" class="btn btn-primary border-radius-0 border-0">Publish <i class="fa fa-hand-o-right"></i></button>
        </div>
    </div>

    {{ Form::close() }}


@stop