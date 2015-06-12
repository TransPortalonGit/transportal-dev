@extends('layouts.master')

@section('head')

{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}

@include('site/partials/_tags-head')

@stop

@section('content')
<div class="content_container container">
    
    <div class="row">    
        
        <div class="col-sm-12">
            <div id="browse-header" style="margin: 30px 0px 20px">
                <h2><a href="{{ Request::url() }}">Projects</a></h2>
            </div>
        </div>

        <div class="col-sm-2">

            <form method="GET" id="pagination" title="pagination">
                <select class="form-control" name="pporder" id="pporder">
                    <option value="title" @if($sortby == 'title') selected @endif>Alphabetic</option>
                    <option value="created_at" @if($sortby == 'created_at') selected @endif>Most Recent</option>
                    <option value="views" @if($sortby == 'views') selected @endif>Most Viewed</option>
                    <option value="favorite" @if($sortby == 'favorite') selected @endif>Most Popular</option>
                </select>
            </form>

        </div>

        <div class="col-sm-8">
            <form method="GET" action="/explore/publicprojects/search" class="form-inline">
                <input type="search" name="search" id="search" placeholder="Search for projects..." class="form-control" />
                <button type="submit" class="form-control btn btn-success">Submit</button>
            </form>

        </div>

    </div>

    <br />

        <div class="panel panel-default">
            <div class="panel-body" style="padding-right: 0">
                <div class="all_projects row" style="margin: 0">
                    @foreach($projects as $project)       
                        @include('partials._projectpreview')        
                    @endforeach
                </div> 
            </div>
        </div>

    {{$projects->appends(Request::except('page'))->links();}}

</div>

<div class="clearfix"></div>


<script type="text/javascript">
    (function(){
        setAutoSubmit();
    })();

$('#pporder').change(
    function() {
        $('#pagination').trigger('submit');
    });


</script>
@stop