@foreach($wanted as $wantedItem)
    @if($projects[$wantedItem->id])
        <div class="wanted-item">
            <a class="wanted-title" href="/project/{{$projects[$wantedItem->id]->id}}">{{$projects[$wantedItem->id]->title}}</a>
            <div class="wanted-description">
                {{$wantedItem->description}}
            </div>
            <div class="wanted-progress">
                @if(count($projectUsers[$wantedItem->id])<$wantedItem->wanted_count)
                <div class="space-available">
                    {{count($projectUsers[$wantedItem->id])}}/{{$wantedItem->wanted_count}}
                </div>
                @else
                <div class="no-space-available">
                    {{count($projectUsers[$wantedItem->id])}}/{{$wantedItem->wanted_count}}
                </div>
                @endif
            </div>
            <div class="wanted-info">
                @if(Sentry::check())
                    @if($projects[$wantedItem->id]->user_id == Sentry::getUser()->id )
                        <p>This is your own project</p>
                        @elseif($allreadyParticipating[$wantedItem->id])
                            @if($pending[$wantedItem->id])
                                <p>Waint until {{$projects[$wantedItem->id]->user->username}} accepts you</p>
                                <a href="#" class="btn btn-primary btn-xs border-radius-0 border-0">Contact Owner</a>
                            @else
                                <p>You are allready participating in this Project.</p>
                                <a href="#" class="btn btn-primary btn-xs border-radius-0 border-0" style="float: right; margin-top: -25px;">Contact Owner</a>
                            @endif
                    @else
                        @if(count($projectUsers[$wantedItem->id])===$wantedItem->wanted_count)
                            <p>Project Allready Full</p>
                            <a href="#" class="btn btn-primary btn-xs border-radius-0 border-0">Contact Owner</a>
                        @else
                            <div class="wanted-buttons">
                                <a href="/explore/wanted/participate/{{$projects[$wantedItem->id]->id}}" class="btn btn-success btn-xs border-radius-0 border-0">Participate</a>
                                <a href="#" class="btn btn-primary btn-xs border-radius-0 border-0">Contact Owner</a>
                            </div>
                            <p class="wanted-owner">by <a >{{$projects[$wantedItem->id]->user->username}}</a></p>
                        @endif
                    @endif
                @else
                    <p>Log on to participate</p>
                @endif
            </div>
        </div>
    @endif
@endforeach

