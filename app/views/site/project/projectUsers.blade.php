@section('projectUsers')
    @if($projectUsers !== "")
        <div id="projectusers">
        <i class="fa fa-group"></i> Members: {{ $projectUsersAccepted }}
        @if($user !== NULL && $project->user_id == $user->id)
            <div>
                @if($projectUsersApplied > 0)
                    <i class="fa fa-question-circle"></i> {{ $projectUsersApplied }} Request(s)
                @endif
            </div>
        @endif
        </div>
    @endif
@stop