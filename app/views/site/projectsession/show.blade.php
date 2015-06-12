@extends('layouts.master')


@section('head')
{{HTML::style('/css/project.css')}}

<script type="text/javascript">

function delete_project() {
    bootbox.confirm("<h3>Do you really want to delete this project?</h3>", function(result) {
        if (result) {
            $("form").submit();
        }
    }); 
}
</script>

@stop

@section('content')

                    <?php
                      $Allfiles = array();
                      $images = array();
                      $docpaths = array();
                      $docnames = array();
                      $documents = array()
                    ?>
                      @if(!empty($projectsession->files))
                        <?php array_push($Allfiles, [explode(',', $projectsession->files), $projectsession->id, $projectsession->step]); ?>
                      @endif

                      @if(!empty($projectsession->docs))
                        <?php
                          array_push($docpaths, explode(',', $projectsession->docs));
                          array_push($docnames, explode(',', $projectsession->docnames));
                        ?>
                      @endif
                     
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


@if (Session::has('notification'))
  <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>{{ Session::get('notification') }}</strong>
  </div>
@endif

 <div class="container-fluid projectview">
  <div class="row">
    <div class="col-md-12">
      <!--Header-->
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12 page-header">
              
              <h2>{{$projectsession->step}}</h2>
              
              <h5>Workstep in project: <span class="glyphicon glyphicon-{{$projectsession->project->icon}} {{$projectsession->project->color;}}"></span> {{HTML::linkAction('ProjectController@show', $projectsession->project->title, $projectsession->project->id)}}</h5>
              
            </div>
          </div>
        </div> 
      </div>


      <div class="row">
       <!--Spalte links-->
       <div class="col-md-5">
       @if(Sentry::check() && $projectsession->project->user_id == Sentry::getUser()->id)
          <div class="panel panel-transportal">
              <button type="button" class="panel-heading btn btn-block btn-success" data-toggle="collapse" data-target="#manage">
                <h3 class="panel-title">Manage <span class="caret"></span></h3>
              </button>
              <div class="list-group collapse in" id="manage">
                <a href="{{$projectsession->id}}/edit" class="list-group-item"><span class="glyphicon glyphicon-edit"></span> Edit workstep</a>
                <a href="create" class="list-group-item"><span class="glyphicon glyphicon-plus"></span> Create a new workstep</a>
               
              </div>
          </div>
        @endif

        <div class="panel panel-transportal table-responsive">
          <button type="button" class="panel-heading btn btn-block btn-success" data-toggle="collapse" data-target="#details">
            <h3 class="panel-title">Details <span class="caret"></span></h3>
          </button>

          <table class="table collapse in" id="details">
            <tr><td class="text-right col-md-4"><strong>Duration:</strong></td><td>{{$projectsession->duration?$projectsession->duration:'-'}}</td></tr>
            <tr><td class="text-right"><strong>Technology:</strong></td><td>{{$projectsession->technology?$projectsession->technology:'-'}}</td></tr>
            <tr><td class="text-right"><strong>Material:</strong></td><td>{{$projectsession->material?$projectsession->material:'-'}}</td></tr>
            <tr><td class="text-right"><strong>Costs:</strong></td><td>{{$projectsession->costs?$projectsession->costs:'0'}} €</td></tr>
            <tr><td class="text-right"><strong>Project:</strong></td><td>{{ HTML::linkAction('ProjectController@show', $projectsession->project->title, array($projectsession->project->id))}}</td></tr>
            <tr><td class="text-right"><strong>Owner:</strong></td><td>{{ HTML::linkAction('ProfileController@getShow', $projectsession->project->user->username, array($projectsession->project->user->username))}}</td></tr>
            <tr><td class="text-right"><strong>Step created:</strong></td><td>{{ date("d.m.Y - H:i", strtotime($projectsession->created_at)) }}</td></tr>
            <tr><td class="text-right"><strong>Last updated:</strong></td><td>{{ date("d.m.Y - H:i", strtotime($projectsession->updated_at)) }}</td></tr>
          </table>   
        </div>

        @if(!empty($documents))
        <div class="panel panel-transportal">
          <button class="panel-heading btn btn-block btn-success" data-toggle="collapse" data-target="#files">
            <h3 class="panel-title">Workstep files <span class="caret"></span></h3>
          </button>
          <div class="panel-body collapse in" id="files">
            <ul class="list-group">
              @foreach($documents as $document)
                <li class="list-group-item">
                  <a href="{{$document[0]}}">{{$document[1]}}</a>
                </li>       
              @endforeach
            </ul>

            <div class="pull-right">
              <a href="/projectsession/{{$projectsession->id}}/download" class="btn btn-xs btn-default" title="Download all files">Download as ZIP</a>
            </div>
          </div>
        </div>
        @endif
           
        </div>

        <!--Spalte rechts-->
        <div class="col-md-7">
        @if(!empty($images))
            <div class="panel panel-transportal"><div class="panel-body">
              <div id="project-carousel" class="carousel slide project-carousel">
                <div class="carousel-inner">
                  <?php
                    $first = true;
                  ?>
                  @foreach($images as $img)
                    <div class="item {{($first)?'active':'';}}">
                      <a href="{{$img[0]}}">
                      <img src="{{$img[0]}}" alt="...">
                      </a>
                    </div>
                    <?php
                    $first = false;
                    ?>
                  @endforeach
                </div>

                @if(count($images) > 1)
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
        @endif

          <div class="panel panel-transportal">
            <div class="panel-heading">
            <h3 class="panel-title projectview">Workstep Description</h3>
            </div>
            <div class="panel-body">
              {{$projectsession->description}}
            </div>
          </div>

          <div class="panel panel-transportal">
            <div class="panel-heading">
            <h3 class="panel-title projectview">Other worksteps on this project</h3>
            </div>
                @if(!$projectsession->project->projectsessions->first())
                  @if(Sentry::check() && $projectsession->project->user_id == Sentry::getUser()->id)
                    <ul class="list-group">
                    <li class="list-group-item">{{ HTML::linkAction('ProjectSessionController@create', 'Start the first step!', Session::flash('project_id', $projectsession->project->id), array('class' => 'btn btn-sm btn-default'))}}</li>
                    </ul>
                  @else
                    <ul class="list-group">
                    <li class="list-group-item">This project does not have any worksteps yet.</li>
                    </ul>
                  @endif
                @else
                  <ul class="list-group">
                  @foreach($projectsession->project->projectsessions as $psession)
                    <li data-toggle="collapse" data-target="#{{$psession->step}}" class="list-group-item">

                    <big>
                      {{HTML::linkAction('ProjectSessionController@show', $psession->step, $psession->id)}}
                      <a data-toggle="collapse" href="#{{$psession->id}}"><small>(Show details <span class="caret"></span> ) </small></a>
                    </big>
                    <div id="{{$psession->id}}" class="collapse">
                      {{$psession->description}}
                      <div class="pull-right">
                      {{HTML::linkAction('ProjectSessionController@show', 'Show workstep', $psession->id, array("class" => "btn btn-xs btn-success"))}}
                        @if (Sentry::Check() && Sentry::getUser()->hasAccess('is_admin'))
                          <a href="{{action('ProjectSessionController@edit', $psession->id)}}" class="btn btn-warning btn-xs"><i class = "glyphicon glyphicon-edit"></i> Edit</a>
                        @endif
                      </div>
                    </div>
                    </li>
                  @endforeach
                  @if(Sentry::check() && $projectsession->project->user_id == Sentry::getUser()->id)
                    <li class="list-group-item">{{ HTML::linkAction('ProjectSessionController@create', 'Start a new workstep', Session::flash('project_id', $projectsession->project->id), array('class' => 'btn btn-sm btn-default'))}}</li>
                  @endif
                  </ul>
                @endif 
          </div>

        </div>

      </div>
    </div>
  </div>
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