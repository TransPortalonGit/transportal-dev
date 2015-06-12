@extends('layouts.master')

@section('head')
{{ HTML::style('css/wantedListing.css') }}

{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}

<script type="text/javascript" src="/js/question_edit.js"></script>
<link rel="stylesheet" href="/css/index-question-answers.css">

{{ HTML::style('css/multiselect.css'); }}
{{ HTML::script('js/multiselect.js'); }}
<script type="text/javascript">
    $(document).ready(function() {
        $('#tags').multiselect({
            enableFiltering: true,
            numberDisplayed: 0
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
<div id="browse-header" style="margin: 30px 0px 20px">
    <h2>Wanted</h2>
</div>

<div style="float:left; margin-right: 10px; width: 180px; height: 500px;" >
    <div class="panel panel-default">
        <div class="panel-heading">Filter Options</div>
        <div class="panel-body">
            {{ Form::open(['role' => 'form', 'method' => 'get']) }}

            <div class="form-group" style="width: 50%">
                {{ Form::label('sorting', 'Sorting') }}
                {{ Form::select('sorting', ['old' => 'Oldest', 'new' => 'Newest' ], Input::old('sorting'), ['class' => 'auto-submit']) }}
            </div>

            <div class="form-group" style="width: 80%">
                {{ Form::label('question-show', 'Show Wanteds') }}
                {{ Form::select('question-show', ['all' => 'All', 'yours' => 'Only yours'], Input::old('wanted-show'), ['class' => 'auto-submit']) }}
            </div>

            <div class="form-group" style="width: 50%">
                {{ Form::label('tags', 'Tags') }}
                @include('site.partials.tags-multiple-select')
            </div>
        </div>
    </div>
</div>


<div style="margin-left: 200px; width: 815px"">
    <!-- Searchbar und Button -->
    <div class="form-group form-inline" style="height: 40px;">
        {{ Form::input('search', 'q', Input::old('q'), ['placeholder' => 'Search Wanted...', 'class' => 'form-control', 'style' => 'width: 80%; height: 40px']) }}
        {{ Form::submit('Search', ['class' => 'form-control  btn btn-success', 'style' => 'width: 100px; height: 40px']) }}
        {{ Form::close() }}
    </div>

        <div class="wanted-panel clearfix">
            @if(isset($wanted))

            <div class="wanted-search-result">
            </div>
            @include('site/wantedListings/partials/_grid', ['wanted' => $wanted])
            @else
            <div class="wanted-search-result">
                <p>There are no Projects there</p>
            </div>
            @endif
        </div>
		@if(isset($wanted))
        <div class="pagination">
            {{$wanted->links()}}
        </div>
		@endif
        </div>
    </div>
</div>




<script>
    (function(){
        setAutoSubmit();
    })();
</script>
@stop