@extends('layouts.master')

@section('content')
@if (Session::has('notification'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{ Session::get('notification') }}</strong>
</div>
@endif
<div class="row">
    <div class="col-xs-12">
        <div class="content_container container">

            @include('site.profile._user_profileheader')

            @include('site.profile._user_navigation')

            @yield('question')

        </div>
    </div>
</div>

@stop

