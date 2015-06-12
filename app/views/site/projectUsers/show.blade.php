@extends('layouts.master')

@section('content')
<h4>Manage members of '<a href="/project/{{ $project->id }}">{{ $project->title }}</a>'</h4>
<hr>
<div id="manage-members">
    <p>
        <b>Members</b><br>
        @foreach($project->projectUsers AS $projectUser)
            @if($projectUser->accepted_at != '0000-00-00 00:00:00')
            <div class="pull-left text-center col-lg-offset-1">
                <a href="/profile/show/{{ $projectUser->user->username }}">
                    <img src="{{ $projectUser->user->profilePicture() }}" height="80" alt="{{ $projectUser->user->username }}'s Avatar" title="{{ $projectUser->user->username }}" border="0"><br>
                    {{ $projectUser->user->username }}
                </a>
                @if($projectUser->user_id != $user)
                    <br>
                    {{ Form::model($projectUser, array('route' => array('projectUsers.destroy', $projectUser->id), 'method' => 'DELETE')) }}
                    <button type="submit" class="btn btn-danger btn-xs border-radius-0 border-0"><i class="fa fa-plus fa-rotate-45"></i> Remove</button>
                    {{ Form::close() }}
                @endif
            </div>
            @endif
        @endforeach
        <div class="clearfix"></div>
    </p>
    @if((sizeof($project->projectUsers) - $acceptedCount) > 0)
    <p>
        <b>Requests</b><br>
        @for($i = 0; $i < sizeof($project->projectUsers); $i++)
            @if($project->projectUsers[$i]->accepted_at == '0000-00-00 00:00:00')
                <div class="pull-left text-center col-lg-offset-1">
                    <a href="/profile/show/{{ $project->projectUsers[$i]->user->username }}">
                        <img src="{{ $project->projectUsers[$i]->user->profilePicture() }}" height="80" alt="{{ $project->projectUsers[$i]->user->username }}'s Avatar" title="{{ $project->projectUsers[$i]->user->username }}" border="0"><br>
                        {{ $project->projectUsers[$i]->user->username }}
                    </a><br>
                    {{ Form::model($project->projectUsers[$i], array('route' => array('projectUsers.update', $project->projectUsers[$i]->id), 'method' => 'PUT')) }}
                        {{ Form::hidden('accept', 1) }}
                        <button type="submit" class="btn btn-success btn-xs border-radius-0 border-0"><span class="fa fa-thumbs-up"></span> Accept</button>
                    {{ Form::close() }}
                    {{ Form::model($project->projectUsers[$i], array('route' => array('projectUsers.update', $project->projectUsers[$i]->id), 'method' => 'PUT')) }}
                        {{ Form::hidden('accept', 0) }}
                        <button type="submit" class="btn btn-danger btn-xs border-radius-0 border-0"><span class="fa fa-thumbs-down"></span> Deny</button>
                    {{ Form::close() }}
                </div>
            @endif
        @endfor
    </p>
    @endif
</div>

@stop