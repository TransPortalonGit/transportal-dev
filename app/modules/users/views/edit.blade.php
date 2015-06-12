@extends('layouts.admin')

@section('content')

<br />

<ol class="breadcrumb">
  <li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
  <li><a href="/admin/users">Users</a></li>
  <li class="active">Edit user</li>
<hr>
</ol>

	<form method="post" action="/admin/users/update" class="form-horizontal" autocomplete="off">

			
				<!-- CSRF Token -->
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="_id" value="{{ $user->id }}" />
		<div class="row">
			<div class="col-xs-3">
				<!-- Role -->
				<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
				<label class="control-label" for="city">Role</label>
					<div>
					<select name="Role" id="Role">
					@if ($user->hasAccess("is_admin"))
					<option value="1">admin</option>
					<option value="2">member</option>
					@else
					<option value="2">member</option>
					<option value="1">admin</option>
					@endif
					</select>
					</div>
				</div>
				<!-- Username -->
				<div class="control-group {{ $errors->has('username') ? 'error' : '' }}">
				<label class="control-label" for="username">Username*</label>
					<div class="controls">
						<input type="text" name="username" id="username" value="{{ $user->username }}" />
						{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- Title -->
				<div class="control-group {{ $errors->has('title') ? 'error' : '' }}">
				<label class="control-label" for="title">Title</label>
					<div class="controls">
						<input type="text" name="title" id="title" value="{{ $user->title }}" />
						{{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>


				<!-- First Name -->
				<div class="control-group {{ $errors->has('first_name') ? 'error' : '' }}">
				<label class="control-label" for="first_name">First Name*</label>
					<div class="controls">
						<input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" />
						{{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- Last Name -->
				<div class="control-group {{ $errors->has('last_name') ? 'error' : '' }}">
					<label class="control-label" for="last_name">Last Name*</label>
					<div class="controls">
						<input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" />
						{{ $errors->first('last_name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- Email -->
				<div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
					<label class="control-label" for="email">Email*</label>
					<div class="controls">
						<input type="text" name="email" id="email" value="{{ $user->email }}" />
						{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
			<div class="col-xs-3">

				<!-- Company -->
				<div class="control-group {{ $errors->has('company') ? 'error' : '' }}">
				<label class="control-label" for="company">Company</label>
					<div class="controls">
						<input type="text" name="company" id="company" value="{{ $user->company }}" />
						{{ $errors->first('company', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			
				<!-- Street -->
				<div class="control-group {{ $errors->has('street') ? 'error' : '' }}">
				<label class="control-label" for="street">Street</label>
					<div class="controls">
						<input type="text" name="street" id="street" value="{{ $user->street }}" />
						{{ $errors->first('street', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- Zipcode -->
				<div class="control-group {{ $errors->has('zipcode') ? 'error' : '' }}">
				<label class="control-label" for="zipcode">Zipcode</label>
					<div class="controls">
						<input type="text" name="zipcode" id="zipcode" value="{{ $user->zipcode }}" />
						{{ $errors->first('zipcode', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- City -->
				<div class="control-group {{ $errors->has('city') ? 'error' : '' }}">
				<label class="control-label" for="city">City</label>
					<div class="controls">
						<input type="text" name="city" id="city" value="{{ $user->city }}" />
						{{ $errors->first('city', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- Privileges -->
				<div class="control-group {{ $errors->has('permissions') ? 'error' : '' }}">
				<label class="control-label" for="permissions">Permissions</label>
					<div class="controls">
						<!--@if($user->hasAccess('3d_printer'))
						<input type="checkbox" name="p_3dprinter" id="" value="1" checked />3D Printer
						@else
						<input type="checkbox" name="p_3dprinter" id="" value="1" />3D Printer
						@endif
						<p> </p>
						@if($user->hasAccess('lasercutter'))
						<input type="checkbox" name="p_lasercutter" id="" value="1" checked />Laser Cutter
						@else
						<input type="checkbox" name="p_lasercutter" id="" value="1" />Laser Cutter
						@endif
						{{ $errors->first('permissions', '<span class="help-inline">:message</span>') }}-->
						
						@foreach($machines as $m)
						@if($user->hasAccess($m->type))
						<input type="checkbox" name="{{ $m->type; }}" id="" value="1" checked />&nbsp;{{ $m->name }}
						@else
						<input type="checkbox" name="{{ $m->type; }}" id="" value="1" />&nbsp;{{ $m->name }}
						@endif
						<br>
						@endforeach 
					</div>
				</div>
			</div>
		</div>
			<div class="control-group">
					<label class="control-label" for=""></label>
					<div class="controls">
						* required fields
						<p>
						</p>
					</div>
				</div>
			<!-- Form actions -->
				<div class="control-group">
					<div class="controls">
						<a href="/admin/users"><button type="button" class="btn btn-default"> Cancel</button></a>
						<button type="submit" onclick="{{ $user->id }}" class="btn btn-primary"> Apply</button>
					</div>
				</div>
			</form>


@stop