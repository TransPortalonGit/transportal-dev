@extends('layouts.master')

@section('content')



<div class="log-wrapper">
	<div class="log-label">
	<h4>Log into your account</h4>
	</div>
	<div class="form-wrapper">

		<form method="post" action="" class="form-horizontal">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

			{{Session::has('error') ? '<p class="alert alert-warning">' . Session::get('error') . '</p>' : '' }}
			
			<!-- Email -->
			<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
				<label class="control-label" for="username">Username</label>
				<div class="controls">
					<input type="text" name="username" id="username" value="{{ Input::old('username') }}" />
					{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Password -->
			<div class="control-group {{ $errors->has('password') ? 'error' : '' }}" >
				<label class="control-label" for="password">Password</label>
				<div class="controls">
					<input type="password" name="password" id="password" value="" />
					{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Remember me -->
			<div class="control-group ">
				<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="remember-me" id="remember-me" value="1"/> Remember me
					</label>
				</div>
			</div>

			<!-- Form actions -->
			<div class="control-group" >
				<div class="controls" >
					<button type="submit" class="btn btn-success">Log in</button> <br>

					<a href="{{ URL::to('account/forgot-password') }}">Forgot your password?</a>
				</div>
			</div>
		</form>
	</div>


</div>
@stop