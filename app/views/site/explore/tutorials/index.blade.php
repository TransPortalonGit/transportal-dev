@extends('layouts.master')

@section('head')

<script>

$(document).ready(function() {
  
  $('.cover-item').click(function(e){
    e.preventDefault();
    window.location = $(this).find('a:first').attr('href');
  });
  
});


</script>
@stop


@section('content')

  <div class="row">
  
    <div class="span12">
        <div class="shield">
          <h1>Tutorials</h1>
          @if (Sentry::Check() && Sentry::getUser()->hasAccess('is_admin'))
          <a href="/tutorials/create" class="btn btn-admin"><i class="icon-plus"></i></a>
          @endif
        </div>
        
        @foreach($tutorials as $tutorial)
        <div class="cover-item">
          <div class="cover-item-content">
            <h2><a href="/tutorials/show/{{$tutorial->id}}">{{$tutorial->title}}</a></h2>
            <p>{{$tutorial->description}}</p>
          </div>
          <div class="cover-item-author">By {{$tutorial->user->fullname()}} <span class="muted">– {{date("d.m.Y", strtotime($tutorial->created_at));}}</span></div>
          
        </div>
        @endforeach
        
        {{$tutorials->links();}}

        
    </div>
    
  </div>
@stop