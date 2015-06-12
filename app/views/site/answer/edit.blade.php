@extends('layouts.master')

@section('head')

{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}
@stop

@section('content')



<div style="width: 700px; margin-bottom: 30px">
    <h4 style="float: left;">Edit your Answer</h4>
    <div style="float:right; margin-top: 20px; margin-right: 70px;"><span style="color:#ff0000; font-size: 16px">* </span><span style="font-size: 12px"">required field</span></div>
    <div style="clear:both;"></div>
    <hr>
</div>

{{ Form::model($answer, ['class'=>'form-horizontal', 'role'=>'form', 'route' => ['answer.update', $answer->id], 'method' => 'patch']) }}

<div class="form-group required {{ $errors->first('description')? 'has-error':''; }}">
    {{ Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-5">
        {{ Form::textarea('description', null, ['cols' => '67', 'rows' => '5', 'maxlength' => '2000', 'class' => 'form-control input-sm' ]) }}
        {{ $errors->first('description', '<span class="label label-danger">:message</span>') }}
    </div>
    <span class="info-box">(max. 2000 characters)</span>
</div>


{{ Form::submit('Update', ['class' => 'btn btn-success']) }}

{{ Form::close() }}

@stop