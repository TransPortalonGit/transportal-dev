	
<li {{( preg_match("/^home/i", Request::path()) ) ? 'class="active"' : ''}}><a href="/home" title="Welcome">Home</a></li>

<li class="dropdown {{( preg_match("/^tutorials^/i", Request::path()) ) ? 'active' : ''}}">
	<a href="/tutorials" class="dropdown-toggle" data-toggle="dropdown">Explore <b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="/explore/members">Members</a></li>
		<li class="divider"></li>
		<li><a href="/explore/publicprojects">Projects</a></li>
		<li class="divider"></li>
    	<li><a href="/explore/tools">Fablab tools</a></li>
    	<li class="divider"></li>
    	<li><a href="/explore/tutorials">Tutorials</a></li>
    	<li class="divider"></li>
    	<li><a href="http://www.fablab-bremen.org/wiki/doku.php" target="_blank">Wiki</a></li>
  </ul>
</li>

<li class="dropdown {{( preg_match("/^tutorials^/i", Request::path()) ) ? 'active' : ''}}">
<a href="/tutorials" class="dropdown-toggle" data-toggle="dropdown">Exchange <b class="caret"></b></a>
<ul class="dropdown-menu">
    <li><a href="{{ route('fabboard.listings.index') }}">Marketplace</a></li>
    <li class="divider"></li>
    <li><a href="/explore/wanted">People</a></li>
    <li class="divider"></li>
    <li><a href="/forum">Ideas</a></li>
</ul>
</li>

<li class="dropdown {{( preg_match("/^inventory/i", Request::path()) ) ? 'active' : ''}}" >
	<a href="/inventory" class="dropdown-toggle" data-toggle="dropdown">Create <b class="caret"></b></a>
	<ul class="dropdown-menu">
        <li>{{ link_to_route('fabboard.listings.create', 'Listing') }}</li>
        <li class="divider"></li>
        <li><a href="/project/create">Project</a></li>
       	<li class="divider"></li>
        <li><a href="/profile/appointments">Appointment</a></li>
        <li class="divider"></li>
        <li><a href="http://www.fablab-bremen.org/wiki/doku.php?id=start" target="_blank">Wiki-entry</a></li>
  	</ul>
</li>

@if (Sentry::check()) 
<li class="dropdown pull-right {{( preg_match("/^profile/i", Request::path()) ) ? 'active' : ''}}" id="dropdown-menu">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#dropdown-menu">{{ucfirst(Sentry::getUser()->username)}}<b class="caret"></b></a>
	<ul class="dropdown-menu">
		<li><a href="/profile/show/{{Sentry::getUser()->username}}" title="Profile"><i class="fa  fa-tachometer" style="margin-right: 10px;"></i>Profile</a></li>
		@if (Sentry::getUser()->hasAccess('is_admin'))
		<li class="divider"></li>
		<li><a href="/admin" title="Admin"><i class="fa fa-user" style="margin-right: 10px;"></i>Admin</a></li>
		<li class="divider"></li>
		@endif
		<li><a href="/profile/setting" title="Manage"> <i class="fa  fa-cog" style="margin-right: 10px;"></i>Settings</a></li>
		<li class="divider"></li>
		<li><a href="/account/logout" title="Log out"> <i class="fa  fa-reply" style="margin-right: 10px;"></i>Log out</a></li>

	</ul>
</li>

@else

<li class="dropdown pull-right" id="dropdown-menu">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#dropdown-menu">Login<b class="caret"></b></a>
	<div class="dropdown-menu" style="width: 180px;">
		<form style="margin: 0px" accept-charset="UTF-8" action="/account/login" method="post">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			<fieldset class='textbox' style="padding:10px">
				<input style="margin-top: 8px; width: 155px" type="text" placeholder="Username" name="username"/>
				<input style="margin-top: 8px; width: 155px" type="password" placeholder="Password" name="password"/>
				<input style="margin-top: 8px; border-radius:0; background-color: #34a26a;" class="btn btn-primary btn-block" name="commit" type="submit" value="Log In"/>
			</fieldset>
		</form>
	</div>
</li>

@endif

<div class="search"> 
  	<form class="navbar-form navbar-left" role="search">
  		<div class="form-group">
    		<input type="text" class="form-control" placeholder=" search ">
  		</div>
      <button type="submit" class="btn btn-search "><i class="fa fa-search"></i></button>
	</form>
</div>

