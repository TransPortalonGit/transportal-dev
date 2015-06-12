@extends('layouts.master')

@section('head')
{{HTML::style('/css/project.css')}}
{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}
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
<div class="shield">
    <h1>Public projects</h1>
    @if (Sentry::Check())
    <a href="/project/create" class="btn btn-admin"><i class="icon-plus"></i></a>
    @endif
</div>

<!-- Results -->
    @foreach($projects as $project)
        <div class="panel panel-default">
            <div class="media panel panel-body">
                <div class="col-md-4">
                    <a href="#" class="pull-left">
                    <?php
                        $projectsession = null;
                        foreach($project->projectsessions as $psession) {
                            if(!empty($psession->files)) {
                                $projectsession = $psession;
                                break;
                            }
                        }

                        if($projectsession == null) {
                            $img = "/img/images.jpg";
                            echo '<a href="/project/'.$project->id.'">';
                            echo '<img class="media-object img-thumbnail img-responsive" src="'.$img.'">';
                            echo '</a>';
                        } else {
                            $img = explode(',', $projectsession->files);
                            $img = $img[0];
                            echo '<img class="media-object img-thumbnail img-responsive" src="'.$img.'">';
                        }
                    ?>
                    </a>
                </div>
                
                <div class="media-body col-md-8">
                    <p>
                        <h4 class="media-heading">
                        <span class="glyphicon glyphicon-{{$project->icon}} {{$project->color;}}"></span>  {{HTML::linkAction('ProjectController@show', $project->title, $project->id) }}
                        </h4>
                        <div class="clearfix listings-grid-caption">
                            @if($project->user)
                              <small>  {{date("d.m.Y", strtotime($project->created_at));}} by {{ HTML::linkAction('ProfileController@getShow', $project->user->username, array($project->user->username))}}</small>
                            @endif
                        </div>
                        <br>
                        {{{ (strlen($project->content) > 400) ? substr($project->content, 0, 399) . '...' : $project->content }}}
                    </p>
                </div>  
            </div>
        </div>
    @endforeach


{{$projects->links()}}
@stop