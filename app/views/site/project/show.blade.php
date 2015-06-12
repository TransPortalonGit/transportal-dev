<?php 

// Get current time and modify as +1 hour
$time_unformatted = new DateTime;
$time_unformatted = date_modify($time_unformatted, '+1 hour');
$time = $time_unformatted->format('Y-m-d H:i:s');


?>

@extends('layouts.master')

@section('head')

{{HTML::style('/css/project.css')}}

<style type="text/css">

 .main-project-photo a > img, #highlight-photo img {
  width: 100% !important;
  height: auto;
}

</style>

@stop

@section('content')

@if (Session::has('notification'))
  <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>{{ Session::get('notification') }}</strong>
  </div>
@endif

<div class="container-fluid projectview">
  
  <!-- Title -->
  <div class="row">
    <div class="col-md-12">
      <div class="page-header">
        <h1><span class="glyphicon glyphicon-{{$project->icon}} {{$project->color;}}"></span> {{$project->title}}</h1>
      </div>
    </div>
  </div>
      
  <!-- Main --> 
  <div class="row">
    
    <!--Spalte Links-->
    <div class="col-md-4">
      @if(Sentry::check() && $project->user_id == Sentry::getUser()->id)
        <div class="panel panel-transportal">
            <button type="button" class="panel-heading btn btn-block btn-success" data-toggle="collapse" data-target="#manage">
              <h3 class="panel-title">Manage your project <span class="caret"></span></h3>
            </button>
            <div class="list-group collapse in" id="manage">
              <a href="{{$project->id}}/edit" class="list-group-item"> <span class="glyphicon glyphicon-edit"></span> Edit project</a>
              @if(count($projectUsers) !== 0)

                <a href="/projectUsers/{{$project->id}}" class="list-group-item"><span class="glyphicon glyphicon-edit"></span> Manage Team</a>
              @endif
              @if ($user !== NULL && $project->user_id === $user->id)
                  @if($wantedData !== NULL)
                  <a href="/wanted/{{$wantedData->id}}/edit" class="list-group-item"><span class="glyphicon glyphicon-edit"></span> Edit Wanted</a>
                  @else
                  <a href="/wanted/create?project_id={{ $project->id }}" class="list-group-item"><i class="fa fa-plus-square"></i> Create Wanted</a>
                  @endif
              @endif
              {{ HTML::linkAction('ProjectSessionController@create', 'Start a new workstep', Session::flash('project_id', $project->id), array("class" => "list-group-item"))}}
            </div>
        </div>
      @endif

      <div class="panel panel-transportal">
        <button type="button" class="panel-heading btn btn-block btn-success" data-toggle="collapse" data-target="#details">
          <h3 class="panel-title">Project Details <span class="caret"></span></h3>
        </button>
        <ul class="list-group collapse in" id="details">
          <li class="list-group-item">
            <div class="row">
              <div class="col-md-12">
                @yield('projectUsers')
              </div>
            </div>
          </li>
          @if($wantedData !== NUll )
          <li class="list-group-item">
            <div class="row">
              <div class="col-md-12">
                @yield('wanted')
              </div>
            </div>
          </li>
          @endif

          <li class="list-group-item">
            <div class="row">
              <div class="col-md-12">
                <label>Project started:</label> {{date("d.m.Y", strtotime($project->created_at));}} 
                <br>
                <label>Project Owner:</label> {{ HTML::linkAction('ProfileController@getShow', $project->user->username, array($project->user->username), array())}}
              </div>
            </div>
          </li>

          <li class="list-group-item">
                <div class="row">
                  <div class="col-md-12">
                    @if(Sentry::check() && $project->user_id == $currentuser->id)
                      <img src="/img/townmusiciansdarkgrey.png" alt="..."><label><span>&nbsp; Favorites:</span></label><div class="pull-right"><span class="badge"> {{ $project->favorite }} </span></div>
                    @elseif($projectfavorite == 1)
                      <a href="/project/unfavorite/{{$userfavorite_id}}"><img src="/img/townmusiciansdarkgrey.png" alt="..." onmouseover="this.src='/img/townmusicianshover.png'" onmouseout="this.src='/img/townmusiciansdarkgrey.png'"><label class="viss"><span>&nbsp; Your Favorite!</span></label><div class="pull-right"><span class="badge"> {{ $project->favorite }} </span></div></a>
                    @else
                      <a href="/project/favorite/{{$project->id}}" class="text-center"><img src="/img/townmusiciansdarkgrey.png" alt="..." onmouseover="this.src='/img/townmusicianshover.png'" onmouseout="this.src='/img/townmusiciansdarkgrey.png'"><label class="vissmousepointer"><span>&nbsp; Mark as favorite</span></label><div class="pull-right"><span class="badge"> {{ $project->favorite }} </span></div></a>
                    @endif
                  </div>
                </div>
          </li>

          <li class="list-group-item">
            <div class="row">
              <div class="col-md-12">
                <i class="fa fa-eye fa-2x" style="color: DimGray;"></i><label><span>&nbsp; Views: </span></label><div class="pull-right"><span class="badge">{{ $project->views }} </span></div>
              </div>
            </div>
          </li>

          <li class="list-group-item">
            <div class="row">
              <div class="col-md-12">
                  <h4>Files</h4>
                  <?php
                    $Allfiles = array();
                    $images = array();
                    $docpaths = array();
                    $docnames = array();
                    $documents = array()
                  ?>
                  @foreach($project->projectsessions as $psession)
                    @if(!empty($psession->files))
                      <?php array_push($Allfiles, [explode(',', $psession->files), $psession->id, $psession->step]); ?>
                    @endif

                    @if(!empty($psession->docs))
                      <?php
                        array_push($docpaths, explode(',', $psession->docs));
                        array_push($docnames, explode(',', $psession->docnames));
                      ?>
                    @endif

                  @endforeach
                   
                  @foreach($Allfiles as $files)
                      <?php if(!empty($files[0])) {
                        foreach($files[0] as $file) {
                          array_push($images, [$file, $files[1], $files[2]]);
                        }
                      } ?>
                  @endforeach

                 
                  <?php $i = 0; ?>
                  @foreach($docpaths as $docpath)  
                    <?php $j = 0; ?>
                    @foreach($docpath as $dp)        
                      <?php
                      array_push($documents, [$docpaths[$i][$j], $docnames[$i][$j]]);
                      ?>
                      <?php $j++;?>
                    @endforeach
                    <?php $i++;?>
                  @endforeach                    

                  @if(!empty($documents))
                  <ul class="list-group">
                    @foreach($documents as $document)
                      <li class="list-group-item">
                          <a href="{{$document[0]}}">{{$document[1]}}</a>
                          <div class="pull-right">
                          <form method="GET" action="/projects/download/{{$project->id}}" enctype="multipart/form-data">
                          <a href="{{$document[0]}}" target="_blank" title="Download file" download="{{$project->title}} - {{$document[1]}}">
                            <i class="fa fa-download" style="font-size: 16px"></i>
                          </a>
                          </form>
                          </div>
                      </li>       
                    @endforeach
                  </ul>
                  <div class="pull-right">
                      
                        <a href="/project/{{$project->id}}/download" class="btn btn-xs btn-default" title="Download all project files">Download All</a>
                      
                  </div>
                @else
                  No files submitted.
                @endif
              </div>
            </div>
          </li>
        </ul>
      </div>

      <div class="panel panel-transportal">
          <button type="button" class="panel-heading btn btn-block btn-success" data-toggle="collapse" data-target="#other">
          @if(Sentry::check() && $project->user_id == Sentry::getUser()->id)
            <h3 class="panel-title">{{ HTML::linkAction('ProjectController@index', 'Your other projects')}} <span class="caret"></span></h3>
          @else
            <h3 class="panel-title">Other projects by {{ HTML::linkAction('ProfileController@getShow', $project->user->username, array($project->user->username), array())}} <span class="caret"></span></h3>            
          @endif
          </button>
   
        <ul class="list-group collapse in" id="other">
          @foreach($project->user->projects->take(10) as $uproject)
            <li class="list-group-item"><span class="glyphicon glyphicon-{{$uproject->icon}} {{$uproject->color}}"></span> {{ HTML::linkAction('ProjectController@show', $uproject->title, array($uproject->id), array())}}</li>
          @endforeach
        </ul>
      </div>
    </div>

          <!--Spalte rechts-->
          <div class="col-md-8">
          
              <div class="panel panel-transportal"><div class="panel-body">
                <div id="project-carousel" class="carousel slide project-carousel">
                  <div class="carousel-inner">
                    <?php
                      $first = true;
                    ?>
                    @if(!empty($images))
                      @foreach($images as $img)
                        <div class="item {{($first)?'active':'';}}">
                          <a href="/projectsession/{{$img[1]}}">
                          <img src="{{$img[0]}}" alt="...">
                          <div class="carousel-caption"> 
                            <h3>Picture of workstep "{{$img[2]}}"</h3>
                          </div>
                          </a>
                        </div>
                        <?php
                        $first = false;
                        ?>
                      @endforeach
                    @else
                      <div class="item active">
                          <img src="/img/projectdummy2.png" alt="...">
                          </a>
                        </div>
                    @endif

                  </div>
                  @if(count($images)>1)
                  <div class="controller">
                    <a class="left carousel-control" href="#project-carousel" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#project-carousel" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                  </div>
                  @endif      
                </div>
              </div></div>
            

            <div class="panel panel-transportal">
              <div class="panel-heading">
              <h3 class="panel-title projectview">Project Description</h3>
              </div>
              <div class="panel-body">
                {{$project->content}}
              </div>
            </div>

            <div class="panel panel-transportal">
              <div class="panel-heading">
              <h3 class="panel-title projectview">{{HTML::linkAction('ProjectSessionController@index', 'Worksteps')}}</h3>
              </div>
                  @if(!$project->projectsessions->first())
                    @if(Sentry::check() && $project->user_id == Sentry::getUser()->id)
                      <ul class="list-group">
                      <li class="list-group-item">{{ HTML::linkAction('ProjectSessionController@create', 'Start the first step!', Session::flash('project_id', $project->id), array('class' => 'btn btn-sm btn-default'))}}</li>
                      </ul>
                    @else
                      <ul class="list-group">
                      <li class="list-group-item">This project does not have any worksteps yet.</li>
                      </ul>
                    @endif
                  @else
                    <ul class="list-group">
                    @foreach($project->projectsessions as $psession)
                      <li data-toggle="collapse" data-target="#{{$psession->step}}" class="list-group-item">
                      
                      <big>
                        {{HTML::linkAction('ProjectSessionController@show', $psession->step, $psession->id)}}
                        <a data-toggle="collapse" href="#{{$psession->id}}"><small>(Show details <span class="caret"></span> ) </small></a>
                      </big>
                      <div id="{{$psession->id}}" class="collapse">
                        {{$psession->description}}
                        
                        {{HTML::linkAction('ProjectSessionController@show', 'Show workstep', $psession->id, array("class" => "btn btn-xs btn-success"))}}
                          @if (Sentry::Check() && Sentry::getUser()->hasAccess('is_admin'))
                            <a href="{{action('ProjectSessionController@edit', $psession->id)}}" class="btn btn-warning btn-xs"><i class = "glyphicon glyphicon-edit"></i> Edit</a>
                            {{Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', array('type' => 'button', 'onclick' => 'delete_project()', 'class' => 'btn btn-xs btn-danger'))}}
                            {{ Form::close() }} 
                          @endif
                      </div>
                      </li>
                    @endforeach
                    @if(Sentry::check() && $project->user_id == Sentry::getUser()->id)
                      <li class="list-group-item">{{ HTML::linkAction('ProjectSessionController@create', 'Start a new workstep', Session::flash('project_id', $project->id), array('class' => 'btn btn-sm btn-default'))}}</li>
                    @endif
                    </ul>
                  @endif 
            </div>


            <div class="panel panel-transportal">
              <div class="panel-heading">
                <h3 class="panel-title projectview">Questions</h3>
              </div>
              <div class="panel-body">
                @yield('question')
              </div>
            </div>

    </div>

  </div>

  <br />

  <!-- Comment Section -->
  <div class="row">
    <div class="col-md-12">
      <b>Comments</b> (hide <i class="fa fa-caret-up"> </i>)
    </div>
  </div>

     <hr />

  <div class="row" style="padding-bottom: 5px">
    <div class="col-md-12">
        
        <a href="#mycommentbox"><button type="button" class="btn btn-primary btn-xs"> Add comment </button></a>
        
        <select type="select" class="btn btn-default btn-xs" style="margin-left: 10px" >
          <option disable selected>Sort by...</option>
          <option>Most Recent</option>
          <option>Most Voted</option>
          <option>Oldest First</option>
        </select>
  
    </div>
  </div>

  @foreach($comments as $comment)
    <?php $index = $index+1; ?>

    @if($comment->reply_id == "0")
      @include('partials._commentbox')
    @else
      @include('partials._replycommentbox')
    @endif

  @endforeach

  <br />
  <br />

  @if(Sentry::check())
    <form method="post" action="comment/{{$project->id}}" autocomplete="off" enctype="multipart/form-data">

      <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
      <div class="row">
        <div class="commavatar col-md-2"> 
          <img src="/profile-pics/{{Sentry::getUser()->profile_pic}}" class="img-circle">
        </div>
        <div id="mycommentbox" class="col-md-10">
          <div class="form-group">
            <textarea placeholder="{{Sentry::getUser()->username}} says..." rows="4" name="userComment" id="userComment" class="form-control mycommentbox" ></textarea>
          </div>
          <button type="submit" class="btn btn-success"> Submit </button>
        </div>
      </div>

    </form>
  @else
    <hr />
    <div class="row">
      <div class="col-md-12" style="text-align: center">
        Please <a href="http://transportal-dev.informatik.uni-bremen.de/account/login">login</a> to comment.
      </div>
    </div>
  @endif

</div>

<script type="text/javascript">
  $('#myCarousel').carousel({
    interval: 2000
  })

  $('.carousel .item').each(function(){
    var next = $(this).next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
    
    if (next.next().length>0) {
      next.next().children(':first-child').clone().appendTo($(this));
    }
    else {
      $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
  });
</script>
    

@stop