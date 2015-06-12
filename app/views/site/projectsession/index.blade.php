@extends('layouts.master')

@section('head')
{{HTML::style('/css/project.css')}}
<script type="text/javascript">
    $(document).ready(function() {

        $('.cover-item').click(function(e){
            e.preventDefault();
            window.location = $(this).find('a:first').attr('href');
        });

    });
</script>
@stop

@section ('content')
<h1>What is a workstep?</h1>

<div class="panel panel-default">
    <div class="panel-body">
            One workstep can be one workday, or the work with one technology that was used.</p>
        <p> Worksteps are very important, because in a workstep you can upload your project images,
            and all your pictures will be shown on the project site. The project site is public, all users and guests
            of "TransPortal" will see your project description and pictures.</p>
        <a href="{{$referer = $_SERVER['HTTP_REFERER'];}}">
            <button type="button" class="btn btn-succes">Back</button>
        </a>
    </div>
</div>

@stop
