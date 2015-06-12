@extends('layouts.master')

@section('head')
    @include('site/listings/partials/_form-head')
@stop

@section('content')

@include('site/listings/partials/_form-header', ['title' => 'Edit Listing'])

{{ Form::model($listing, ['class'=>'form-horizontal', 'role'=>'form', 'route' => ['fabboard.listings.update', $listing->id], 'method' => 'patch', 'files' => 'true']) }}

    @include('site/listings/partials/_form', ['buttonText' => 'Update Listing', 'edit' => 'true'])

{{ Form::close() }}

@stop