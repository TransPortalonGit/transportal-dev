@extends('layouts.master')

@section('page_header')
	<i class="icon-book"></i> <a href="/tutorials">Tutorials</a> <i class="icon-angle-right"></i> Create new tutorial
@stop

@section('head')



@stop

@section('content')

<form method="post" action="/tutorials/imageupload" enctype="multipart/form-data">

<input name="file" type="file" />
<input type="submit" value="submit" /> 
</form>



@stop