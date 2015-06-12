@extends('layouts.master')

@section('content')

<h1>Forgot your password?</h1>

<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
	
	{{Session::has('error') ? '<p class="alert alert-warning">' . Session::get('error') . '</p>' : '' }}

	{{Session::has('success') ? '<p class="alert alert-success">' . Session::get('success') . '</p>' : '' }}

	<!-- Email -->
	<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
		<label class="control-label" for="username">Username</label>
		<div class="controls">
			<input type="text" name="username" id="username" value="{{ Input::old('username') }}" />
			{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn">Submit</button>
		</div>
	</div>
</form>
@stop
