@extends('layouts.master')

@section('head')
    @include('site/listings/partials/_form-head')
@stop

@section('content')

@include('site/listings/partials/_form-header', ['title' => 'Create a new Listing'])

{{ Form::open(['class'=>'form-horizontal', 'role'=>'form', 'route' => 'fabboard.listings.store', 'method' => 'post', 'files' => 'true']) }}

    @include('site/listings/partials/_form', ['buttonText' => 'Create Listing'])

{{ Form::close() }}

@stop