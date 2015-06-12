@extends('layouts.master')

@section('head')

{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}

@stop

@section('content')

<div style="margin-top: 30px">
    @if ($owner)
        <div class="panel panel-body">
            <h4 style="margin: 0 0 10px 0; padding: 0">Your Listing</h4>

            @if ($listing->isActive())
            <a class="btn btn-warning" href="{{ route('fabboard.listings.edit', $listing->id) }}" >
                Edit
            </a>
            <a class="btn btn-danger" href="" data-toggle="modal" data-target="#myModal-delete">
                Delete
            </a>
            @endif

            @if (!$listing->isActive())
            <a class="btn btn-success" href="{{ route('fabboard.listings.relist', $listing->id) }}" >
                Relist
            </a>
            @endif
        </div>
    @endif
    <div style="margin-bottom: 10px">
        <h4 style="display: inline;">{{{ $listing->title }}}</h4>
    </div>

    <div class="panel panel-default" style="width: 580px; float: left;">
        <div class="panel-body">
            <?php
                ob_start();
                $myImg = new MyImage(public_path() . $listing->getImageToDisplay());
                $i = $myImg->thumbnailbox(550, 385);
                echo "<img src='data:" . $myImg->dataType . ";base64," . base64_encode(ob_get_clean())."'>";
            ?>
            <h4 style="margin-top: 30px;">Description</h4>
            <hr>
            {{{ $listing->description }}}
        </div>
    </div>



    <div class="panel panel-default" style="float:left; width: 320px; margin-left: 20px;">
        <div class="panel-heading">Details</div>
            <div class="panel-body">
                <!-- Default panel contents -->
                <ul style="list-style: none; padding-left: 0;">
                    <li style="width: 120px; float: left; text-align: right; margin-right: 20px">Listing Type:</li>
                    <li>{{ $listing->getType() }}</li>

                    <li style="width: 120px; float: left; text-align: right; margin-right: 20px">Type of Service:</li>
                    <li>{{ $listing->getTypeOfService() }}</li>

                    <li style="width: 120px; float: left; text-align: right; margin-right: 20px"> {{ $listing->isActive() ? 'Ends in:' : 'Ended:' }}</li>
                    <li>{{ $listing->isActive() ? $listing->getTimeLeft() : $listing->getEndedAt() }}</li>
                    <br>

                    <li style="width: 110px; float: left; text-align: right; margin-right: 20px">Lister:</li>
                    <a href="{{ action('ProfileController@getShow', $listing->user->username) }}"> {{ $listing->user->fullname() }}</a>
                </ul>
                @if ($listing->isActive())
                    <div style="margin-left: 130px">
                        @if(Sentry::check())
                            @if(Sentry::getUser()->id != $listing->user_id)
                                <a href="" data-toggle="modal" data-target="#myModal-contact" class="btn btn-success">
                                    <i class="fa fa-envelope-o"></i> Contact
                                </a>
                            @endif
                        @else
                            <a href="/account/login" class="btn btn-success">
                                <i class="fa fa-envelope-o"></i> Contact
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="panel panel-default" style="float:left; width: 320px; margin-left: 20px;">
        <div class="panel-heading">Tags</div>
        <div class="panel-body">
            <?php $listingTags = $listing->tags()->with('tag.getParent')->get(); ?>

            @if(count($listingTags) > 0)

                <?php
                    $tags = array();
                    $parentTags = array();

                    foreach($listingTags as $listingTag){

                        $parentTagId = $listingTag->tag->getParent->id;

                        // Parent Id und Tag Name in Tag-Array schreiben
                        $tags[$parentTagId][$listingTag->tag->id] = $listingTag->tag->tag;

                        // Wenn es den Parent noch nicht im Parenttags-Array gibt
                        if(!isset($parentTags[$parentTagId])){
                            // Parent Id und Parent Name in Parenttags-Array schreiben
                            $parentTags[$parentTagId] = $listingTag->tag->getParent->tag;
                        }

                    }
                ?>

                @foreach($parentTags as $parentId => $parentName)
                    <div style="margin-bottom: 5px">
                        {{ $parentName }}
                    </div>

                    <div style="margin-bottom: 10px">
                        @foreach($tags[$parentId] as $tagId => $tagName)
                            <a href="{{ route('fabboard.listings.index', ['tags[]' => $tagId]) }}"
                               style="margin-bottom: 5px" class="btn btn-info btn-xs"> {{ $tagName }}</a>
                        @endforeach
                    </div>
                @endforeach

            @else
                <p>No Tags</p>
            @endif
        </div>
    </div>



    @if (Sentry::check())
    <div class="modal fade" id="myModal-contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Contact</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(['class'=>'form-horizontal', 'role'=>'form', 'route' => ['fabboard.listings.mail', $listing->id], 'method' => 'post']) }}
                    {{ Form::label('message', 'Message', ['class' => 'col-sm-2']) }}
                    {{ Form::textarea('message', null, ['cols' => '62', 'rows' => '3', 'maxlength' => '1023', 'class' => $errors->first('message', 'error')]) }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    {{ Form::submit('Send', ['class' => 'btn btn-success',]) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($owner && $listing->isActive())
    <div class="modal fade" id="myModal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">#
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Are you sure you want to delete the listing "{{ $listing->title }}"?</h4>
                </div>

                <div style="width: 30%; margin: 30px auto 15px">
                    <div style="float: right">
                        {{ Form::open(['method' => 'delete', 'route' => ['fabboard.listings.destroy', $listing->id]]) }}
                        {{ Form::submit('Delete Listing', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </div>
                    <div style="float:right; margin-right: 5px">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div style="clear: both"></div>

</div>
@stop