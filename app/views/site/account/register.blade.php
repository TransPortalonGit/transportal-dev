@extends('layouts.master')

@section('content')

<h1>Register for a new account</h1>

<form method="post" action="/account/register" class="form-horizontal" autocomplete="off">
	<div class="row">
		<div class="span6">
		
			<!-- CSRF Token -->
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

			<!-- Username -->
			<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
			<label class="control-label" for="username">Username*</label>
				<div class="controls">
					<input type="text" name="username" id="username" value="{{ Input::old('username') }}" />
					{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Title -->
			<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
			<label class="control-label" for="title">Title</label>
				<div class="controls">
					<input type="text" name="title" id="title" value="{{ Input::old('title') }}" />
					{{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>


			<!-- First Name -->
			<div class="control-group {{ $errors->has('first_name') ? 'error' : '' }}">
			<label class="control-label" for="first_name">First Name*</label>
				<div class="controls">
					<input type="text" name="first_name" id="first_name" value="{{ Input::old('first_name') }}" />
					{{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Last Name -->
			<div class="control-group {{ $errors->has('last_name') ? 'error' : '' }}">
				<label class="control-label" for="last_name">Last Name*</label>
				<div class="controls">
					<input type="text" name="last_name" id="last_name" value="{{ Input::old('last_name') }}" />
					{{ $errors->first('last_name', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Email -->
			<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
				<label class="control-label" for="email">Email*</label>
				<div class="controls">
					<input type="text" name="email" id="email" value="{{ Input::old('email') }}" />
					{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Password -->
			<div class="control-group {{ $errors->has('password') ? 'error' : '' }}">
				<label class="control-label" for="password">Password*</label>
				<div class="controls">
					<input type="password" name="password" id="password" value="" />
					{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Password Confirm -->
			<div class="control-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
				<label class="control-label" for="password_confirmation">Password Confirm*</label>
				<div class="controls">
					<input type="password" name="password_confirmation" id="password_confirmation" value="" />
					{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div>
		<div class="span6">
			<!-- Company -->
			<div class="control-group {{ $errors->has('company') ? 'error' : '' }}">
			<label class="control-label" for="company">Company</label>
				<div class="controls">
					<input type="text" name="company" id="company" value="{{ Input::old('company') }}" />
					{{ $errors->first('company', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		
			<!-- Street -->
			<div class="control-group {{ $errors->has('street') ? 'error' : '' }}">
			<label class="control-label" for="street">Street</label>
				<div class="controls">
					<input type="text" name="street" id="street" value="{{ Input::old('street') }}" />
					{{ $errors->first('street', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Zipcode -->
			<div class="control-group {{ $errors->has('zipcode') ? 'error' : '' }}">
			<label class="control-label" for="zipcode">Zipcode</label>
				<div class="controls">
					<input type="text" name="zipcode" id="zipcode" value="{{ Input::old('zipcode') }}" />
					{{ $errors->first('zipcode', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- City -->
			<div class="control-group {{ $errors->has('city') ? 'error' : '' }}">
			<label class="control-label" for="city">City</label>
				<div class="controls">
					<input type="text" name="city" id="city" value="{{ Input::old('city') }}" />
					{{ $errors->first('city', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		
		</div>
	</div>
	<div class="row">
		<div class="span6">
			<div class="control-group">
				<label class="control-label" for=""></label>
				<div class="controls">
					* required fields
				</div>
			</div>

			<!-- Form actions -->
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-primary">Signup</button>
				</div>
			</div>
		</div>
	</div>
</form>

@stop