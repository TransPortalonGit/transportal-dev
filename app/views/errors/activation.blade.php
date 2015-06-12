@extends('layouts.master')

@section('page_header')
	<i class="icon-frown"></i> Oops, something went wrong!
@stop

@section('content')
<div class="row">

	<div class="span12">
		
		{{$error}}
		
	</div>
</div>
@stop