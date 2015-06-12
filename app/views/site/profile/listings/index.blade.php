@extends('layouts.master')
@section('head')

{{ HTML::style('css/listings.css'); }}
{{ HTML::script('js/listings.js'); }}
@include('site/partials/_tags-head')
@stop
@section('content')


<div >
    @if(Session::has('success'))
    <br>
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="content_container container">

            @include('site.profile._user_profileheader')

            @include('site.profile._user_navigation')

            <div style="margin-top: 30px">
                <div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="btn-group">
                                        <button type="button" class="btn @if ($isActive) btn-success @else btn-default @endif">
                                            <a class="listing-status @if ($isActive) listing-status-active @endif" href="{{ route('profile.listings.index') }}">
                                                Active Listings ({{ $activeSum }})</a>
                                        </button>
                                        <button type="button" class="btn @if (!$isActive) btn-success @else btn-default @endif">
                                            <a class="listing-status @if (!$isActive) listing-status-active @endif" href="{{ route('profile.listings.index') }}?status=expired">
                                                Expired Listings ({{ $expiredSum }})</a>
                                        </button>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    {{ link_to_route('fabboard.listings.create', 'Create Listing', null, ['class' => 'btn btn-success']) }}
                                </div>
                            </div>

                        </div>
                        <div class="panel-body">

                            @if ($total > 0)
                            <div style="margin-bottom: 10px;">
                                {{ Form::open(['role' => 'form', 'method' => 'get']) }}
                                <div class="form-group pull-left" style="margin-right: 20px">
                                    {{ Form::label('listing-type', 'Listing-Type') }} <br>
                                    {{ Form::select('listing-type', ['all' => 'All', 'need' => 'Only Needs', 'offer' => 'Only Offers'], Input::old('listing-type'), ['class' => 'auto-submit form-control']) }}
                                </div>

                                <div class="form-group pull-left" style="margin-right: 20px">
                                    {{ Form::label('type-of-service', 'Type of Service') }}<br>
                                    {{ Form::select('type-of-service', ['all' => 'All', 'material' => 'Only Material', 'service' => 'Only Service'], Input::old('type-of-service'), ['class' => 'auto-submit form-control']) }}
                                </div>

                                <div class="form-group pull-left" style="margin-right: 20px">
                                    {{ Form::label('sorting', 'Sorting') }}<br>
                                    @if ($isActive)
                                        {{ Form::select('sorting', ['ending' => 'Ending soonest', 'new' => 'Newly listed'], Input::old('sorting'), ['class' => 'auto-submit form-control']) }}
                                    @else
                                        {{ Form::select('sorting', ['most-recent' => 'Listing End: Most Recent', 'least-recent' => 'Listing End: Least Recent'],
                                            Input::old('sorting'), ['class' => 'auto-submit form-control']) }}
                                    @endif
                                </div>
                                <div class="form-group pull-left">
                                    {{ Form::label('tags', 'Tags') }}<br>
                                    @include('site/partials/_tags-element')
                                </div>
                                <div class="clearfix"></div>

                                @if (!$isActive)
                                    {{ Form::hidden('status', 'expired') }}
                                @endif

                                {{ Form::close() }}
                            </div>
                            @endif

                            @if ($listings->getTotal() > 0)

                            <table class="table" style="table-layout:fixed">
                                <tr>
                                    <th></th>
                                    <th style="width: 260px"></th>
                                    <th style="text-align: center">Listing Type</th>
                                    <th style="text-align: center">Type of Service</th>
                                    <th style="text-align: center; width: 100px">{{ ($isActive) ? 'Ends In' : 'Ended' }}</th>
                                    <th>Actions</th>
                                </tr>
                                <?php $counter = 0; ?>
                                @foreach ($listings as $listing)
                                <tr>
                                    <td>
                                        <div class="listing-image-frame">
                                            <?php
                                                ob_start();
                                                $myImg = new MyImage(public_path() . $listing->getImageToDisplay());
                                                $i = $myImg->thumbnailbox(90, 90);
                                                $buffer = ob_get_clean();
                                                echo "<a href=\"" . route('fabboard.listings.show', [$listing->id]) . "\">";
                                                echo "<img src='data:" . $myImg->dataType . ";base64," . base64_encode($buffer)."'>";
                                                echo "</a>";
                                            ?>
                                        </div>
                                    </td>
                                    <td style="width: 260px; padding-left: 20px; overflow: hidden">
                                        {{ link_to_route('fabboard.listings.show', $listing->title, [$listing->id]) }}
                                    </td>
                                    <td style="text-align: center">{{ $listing->getType() }}</td>
                                    <td style="text-align: center">{{ $listing->getTypeOfService() }}</td>
                                    <td style="text-align: center">{{ ($isActive) ? $listing->getTimeLeft() : $listing->getEndedAt() }}</td>
                                    <td>
                                        @if ($isActive)
                                        <p><a class="btn btn-warning btn-sm" href="{{ route('fabboard.listings.edit', $listing->id) }}">Edit </a> </p>
                                        <a class="btn btn-danger btn-sm" href="" data-toggle="modal" data-target="#myModal-{{ $counter }}">Delete</a>
                                        @else
                                        {{ link_to_route('fabboard.listings.relist', 'Relist', [$listing->id], ['class' => 'btn btn-sm btn-success']) }}
                                        @endif
                                    </td>
                                </tr>

                                <!-- Modal: Delete Listing -->
                                <div class="modal fade" id="myModal-{{ $counter }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
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

                                <?php $counter++; ?>
                                @endforeach
                            </table>

                            @else
                                @if ($total > 0)
                                    <hr>
                                @endif
                                    <div style="font-weight: bold; text-align: center; margin: 20px 0 10px">No Listings</div>
                            @endif

                            <div style="text-align: center">
                                {{ $listings->appends(Input::except(array('page')))->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        setAutoSubmit();
    })();
</script>
@stop