@extends('layouts.master')

@section('head')

{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}

@include('site/partials/_tags-head')

@stop

@section('content')
<div class="content_container container">
    
    <div class="row">    
        
        <div class="col-xs-12">
            <div id="browse-header" style="margin: 30px 0px 20px">
                <h2><a href="{{ Request::url() }}">Members</a></h2>
            </div>
        </div>

        <div class="col-xs-2">

            <form method="GET" id="pagination" title="pagination">
                <select class="form-control" name="m_order" id="m_order">
                    <option value="username" @if($sortby == 'username') selected @endif>Alphabetic</option>
                    <option value="created_at" @if($sortby == 'created_at') selected @endif>Most Recent</option>
                    <option value="Role" @if($sortby == 'Role') selected @endif>Admins First</option>
                </select>
            </form>

        </div>

        <div class="col-xs-4">
            <form method="GET" action="/explore/members/search" class="form-inline">
                <input type="search" name="search" id="search" placeholder="Search for members..." class="form-control" />
                <button type="submit" class="form-control btn btn-success">Submit</button>
            </form>

        </div>

    </div>

    <br />

        <div class="panel panel-default">
            <div class="panel-body" style="padding-right: 0">
                <div class="all_projects row" style="margin: 0">
                    @foreach($users as $user)       
                        @include('partials._memberpreview')        
                    @endforeach
                </div> 
            </div>
        </div>

        {{$users->appends(Request::except('page'))->links();}}

</div>

<div class="clearfix"></div>


<script type="text/javascript">
    (function(){
        setAutoSubmit();
    })();

$('#m_order').change(
    function() {
        $('#pagination').trigger('submit');
    });


</script>
@stop