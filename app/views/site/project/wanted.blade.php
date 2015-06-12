@section('wanted')

@if ($data !== NULL)
    <div id="wanted">
        <h4 style="margin-top: 6px;">Wanted</h4>
        <p>{{$data->description}}</p>
        <div id="wanted-tags" class="project_tag">
            @if (sizeof($wanted_tags) > 0)
                @foreach ($wanted_tags as $wanted_tag)
                <span>{{$wanted_tag->tag->tag}}</span>
                @endforeach
            @endif
        </div>
        @if ($user !== NULL && $project->user_id !== $user->id)
            <div id="wanted-buttons">
                <div class="button-toolbar">
                    {{ Form::open(array('action' => 'ProjectUsersController@store')) }}
                    {{ Form::hidden('project_id', $project->id) }}
                        @if(!in_array($user->id, $project_users))
                        <button type="submit" class="btn btn-success btn-xs border-radius-0 border-0"><i class="fa fa-plus-square"></i> Apply</button>
                        @endif
                        <a href="mailto:{{$project->user->email}}"><div class="btn btn-info btn-xs border-radius-0 border-0"><span class="fa fa-envelope"></span> Contact</div></a>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    </div>
@endif

@stop