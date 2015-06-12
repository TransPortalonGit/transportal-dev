@extends('layouts.master')

@section('head')

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
@if (Session::has('notification'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('notification') }}</strong>
</div>
@endif

<div id="browse-header" style="margin: 30px 0px 20px">
    <h1>Questions</h1>
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

            <div class="form-group" style="width: 50%">
                {{ Form::label('tags', 'Tags') }}
                @include('site.partials.tags-multiple-select')
            </div>
            @if ( isset($project_id) )
            {{Form::hidden('project_id', $project_id)}}
            <div class="form-group" style="width: 100%">
                {{ Form::label('showAll', 'Show all questions') }}
                {{ Form::radio('showAll', '0', false, ['class' => 'auto-submit']) }}
            </div>
            @endif

            <?php $selectedListingTags = $tagsselect['selected'] ?>

            @if(count($selectedListingTags) > 0)
            <?php
            $selectedTags = Tag::whereIn('id', $selectedListingTags)->with('getParent')->get();

            $tags = array();
            $parentTags = array();

            foreach($selectedTags as $tag){
                $parentTagId = $tag->getParent->id;

                // Parent Id und Tag Name in Tag-Array schreiben
                $tags[$parentTagId][$tag->id] = $tag->tag;

                // Wenn es den Parent noch nicht im Parenttags-Array gibt
                if(!isset($parentTags[$parentTagId])){
                    // Parent Id und Parent Name in Parenttags-Array schreiben
                    $parentTags[$parentTagId] = $tag->getParent->tag;
                }
            }
            ?>

            @foreach($parentTags as $parentId => $parentName)
            <div style="margin-bottom: 5px">
                {{ $parentName }}
            </div>

            <div style="margin-bottom: 10px">
                @foreach($tags[$parentId] as $tagId => $tagName)
                <span style="margin-bottom: 5px" class="btn btn-info btn-xs"> {{ $tagName }}</span>
                @endforeach
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>


<div class="container1">
    <!-- Searchbar und Button -->
    <div class="form-group" style="height: 40px;">
        {{ Form::input('search', 'q', Input::old('q'), ['placeholder' => 'Search Questions...', 'class' => 'form-control', 'style' => 'width: 557px; height: 40px; float: left;']) }}
        {{ Form::submit('Search', ['class' => 'form-control btn btn-success', 'style' => 'width: 100px; height: 40px; float: right;']) }}
        {{ Form::close() }}
    </div>


    @if ($questions->count())
    <div style="margin: 0 20px 10px">
        <?php
        $resultText = $questions->getTotal() . ' ';
        $resultText .= ($questions->getTotal() == 1) ? 'Result' : 'Results';

        if(Input::old('q') != null){
            $resultText .= ' for "' . Input::old('q') . '"';
        }

        if ( isset($project_id) ) {
            $project = Project::where('id', '=', $project_id)->first();
            echo $resultText . " for project: " . $project->title;
        } else {
            echo $resultText;
        }


        ?>
    </div>

    <!-- Results -->
    @foreach ($questions as $question)

    <?php $author = User::where('id', '=' , $question->user_id)->first(); ?>
    <?php $project = Project::where('id', '=' , $question->project_id)->first(); ?>


        <div class="single-question">
            <div class="text">
                <h2> by {{$author->username}} in project: {{$project->title}}</h2>
                <a href="question/show?question_id={{ $question->id }}&from=index">
                    <h4>{{$question->title}}</h4>
                </a>
                <?php
                $string =$question->description;
                $string = substr($string,0,200).'...';
                ?>
                <p>{{$string}}</p>

            </div>
        </div>

    @endforeach

    </div>
    @else
    <p>No Results</p>
    @endif

@if (isset($project_id) )
<div style="text-align: center">
    {{ $questions
    ->appends(['sorting' => Input::old('sorting'),
    'q' => Input::old('q'),
    'project_id' => $project_id,
    'tags' => Input::old('tags')])
    ->links()
    }}
</div>
@else

<div style="text-align: center">
    {{ $questions
    ->appends(['sorting' => Input::old('sorting'),
    'q' => Input::old('q'),
    'tags' => Input::old('tags')])
    ->links()
    }}
</div>

@endif

</div>


<script>
    (function(){
        setAutoSubmit();
    })();
</script>

@stop