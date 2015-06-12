@extends('layouts.admin')

@section('content')

<br />

<ol class="breadcrumb">
  <li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
  <li><a href="/admin/users">Users</a></li>
  <li class="active">View user</li>
<hr>
</ol>

<div class="row">
	<div class="col-xs-3">
		<!-- Username -->
		<div>
			<label>Id:</label>
			{{ $user->id }}
		</div>
		<div>
			<label>Role:</label>
			@if ($user->hasAccess("is_admin"))
			Administrator		
			@else
			Member		
			@endif
		</div>
		<div>
			<label>Username:</label>
			{{ $user->username }}
		</div>
		<div>
			<label>Title:</label>
			{{ $user->title }}
		</div>
		<div>
			<label>First Name:</label>
			{{ $user->first_name }}
		</div>
		<div>
			<label>Last Name:</label>
			{{ $user->last_name }}
		</div>
		<div>
			<label>E-mail:</label>
			{{ $user->email }}
		</div>
		<div>
			<label>Company:</label>
			{{ $user->company }}
		</div>
		<div>
			<label>Address:</label>
			{{ $user->street . " " . $user->city . ", " . $user->zipcode }}
		</div>
		<div>
			<label>Permissions:</label>
			<p>3D Printer: @if($user->hasAccess('3d_printer')) &#10004 @else &#10007 @endif</p>
			<p>Laser Cutter: @if($user->hasAccess('lasercutter')) &#10004 @else &#10007 @endif</p>
		</div>
		<div>
			<label>QR-Key:</label>
			<p> {{ HTML::image('qr-pics/' . $user->id . '.png'); }} </p>
		</div>
	</div>
</div>
@stop