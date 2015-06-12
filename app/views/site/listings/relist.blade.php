@extends('layouts.master')

@section('head')
    @include('site/listings/partials/_form-head')
@stop

@section('content')

@include('site/listings/partials/_form-header', ['title' => 'Relist Listing'])

{{ Form::model($listing, ['class'=>'form-horizontal', 'role'=>'form', 'route' => ['fabboard.listings.storeRelist', $listing->id], 'method' => 'post', 'files' => 'true']) }}

    @include('site/listings/partials/_form', ['buttonText' => 'Relist Listing', 'relist' => 'true'])

{{ Form::close() }}

@stop