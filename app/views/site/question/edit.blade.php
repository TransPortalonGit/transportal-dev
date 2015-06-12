@extends('layouts.master')

@section('head')

{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}
{{ HTML::style('css/multiselect.css'); }}
{{ HTML::script('js/multiselect.js'); }}
<script type="text/javascript">
    $(document).ready(function() {
        $('#tags').multiselect({
            enableFiltering: true,
            numberDisplayed: 5
        });
    });

    $(document).on('click', '.multiselect-group', function(event) {
        var checkAll = true;
        var $opts = $(this).parent().nextUntil(':has(.multiselect-group)');
        var $inactive = $opts.filter(':not(.active)');
        var $toggleMe = $inactive;
        if ($inactive.length == 0) {
            $toggleMe = $opts;
            checkAll = false;
        }
        $toggleMe.find('input').click();
        $(this).parent().find('input').prop('checked', checkAll);
    });
</script>
@stop

@section('content')



<div style="width: 700px; margin-bottom: 30px">
    <h4 style="float: left;">Edit your Question</h4>
    <div style="float:right; margin-top: 20px; margin-right: 70px;"><span style="color:#ff0000; font-size: 16px">* </span><span style="font-size: 12px"">required field</span></div>
    <div style="clear:both;"></div>
    <hr>
</div>

{{ Form::model($question, ['class'=>'form-horizontal', 'role'=>'form', 'route' => ['question.update', $question->id], 'method' => 'patch']) }}

<div class="form-group required {{ $errors->first('title')? 'has-error':''; }}">
    {{ Form::label('title', 'Title', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-5">
        {{ Form::text('title', null, ['size' => '60', 'maxlength' => '60', 'class' => 'form-control input-sm' ]) }}
        {{ $errors->first('title', '<span class="label label-danger">:message</span>') }}
    </div>
    <span class="info-box">(max. 60 characters)</span>
</div>

<div class="form-group required {{ $errors->first('description')? 'has-error':''; }}">
    {{ Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-5">
        {{ Form::textarea('description', null, ['cols' => '62', 'rows' => '3', 'maxlength' => '2000', 'class' => 'form-control input-sm' ]) }}
        {{ $errors->first('description', '<span class="label label-danger">:message</span>') }}
    </div>
    <span class="info-box">(max. 2000 characters)</span>
</div>

<div class="form-group">
    {{ Form::label('tags', 'Tags', ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-5">
        @include('site.partials.tags-multiple-select')
    </div>
</div>

<div class="form-group">
    <div class="col-sm-7" style="text-align: right">
        {{ Form::submit('Publish', ['class' => 'btn btn-success']) }}
    </div>
</div>

{{ Form::close() }}


@stop