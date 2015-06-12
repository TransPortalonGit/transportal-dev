<div class= "main_tabs">
	<ul class="nav nav-pills nav-justified">
	  <li {{( preg_match("#profile/show#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/show/{{$user->username}}">Profile</a>
	  </li>
      <li {{( preg_match("#profile/listings#i", Request::path()) ) ? 'class="active"' : ''}}>
        <a href="/profile/listings">Listings</a>
      </li>
      <li {{( preg_match("#profile/questions#i", Request::path()) ) ? 'class="active"' : ''}}>
        <a href="/profile/questions">Questions</a>
      </li>
	  <li {{( preg_match("#profile/projects#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/projects">Projects</a>
	  </li>
	  <li {{( preg_match("#profile/appointments#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/appointments">Appointments</a>
	  </li>
	  <li {{( preg_match("#profile/inventory#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/inventory">Inventory</a>
	  </li>
	</ul>
</div>
<div class="navi-dropdown col-xs-12" style="padding:0; margin:0; display: none;">
<div class="btn-group">
  <button type="button" class="btn btn-success">Navigation</button>
  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
    <span class="caret" style="color: #ffffff;"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li {{( preg_match("#profile/show#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/show/{{$user->username}}">Dashboard</a>
	  </li>
	  <li {{( preg_match("#profile/projects#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/projects">Projects</a>
	  </li>
	  <li {{( preg_match("#profile/appointments#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/appointments">Appointments</a>
	  </li>
	  <li {{( preg_match("#profile/inventory#i", Request::path()) ) ? 'class="active"' : ''}}>
	    <a href="/profile/inventory">Inventory</a>
	  </li>
  </ul>
</div>
</div>