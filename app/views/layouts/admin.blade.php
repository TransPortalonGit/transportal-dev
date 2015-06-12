<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	
	<title>TransPortal - Administration</title>

	@include('layouts._head')
	@yield('head')

	{{HTML::style('/css/sb-admin.css')}}
	

</head>
<body>

     <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="header-wrapper">
	        <div class="navbar-header">
	          	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
	            	<span class="sr-only">Toggle navigation</span>
	            	<span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		        </button>
	          	
				<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="container">
				<a class="navbar-brand logo" href="/home">
	          		<img src="/img/transportal-logo.png" />
				</a>
		        <div class="collapse navbar-collapse navbar-main-collapse"  >
		            <ul class="nav navbar-nav navbar-right navbar-user">
					@include('layouts._navigation')
		          	</ul>
		        </div><!-- /.navbar-collapse -->
	        </div>
	        </div>      
        </div>
     </nav>
	

    		
      
      

      <div class="content_container container">

      	<div data-spy: "affix" id="wrapper" style="float: left; ">  
      		<div class="row">    		    		
		      	<ul class="nav nav-pills nav-stacked side-nav">
		          	<li class="{{( preg_match("#admin/dashboard#i", Request::path()) ) ? 'active' : ''}}"><a href="/admin/dashboard"><span class="fa fa-tachometer"></span> Dashboard</a></li>
					<li class="{{( preg_match("#admin/inventory#i", Request::path()) ) ? 'active' : ''}}"><a href="/admin/inventory"><span class="fa fa-table"></span> Inventory</a></li>
					<li class="{{( preg_match("#admin/users#i", Request::path()) ) ? 'active' : ''}}"><a href="/admin/users"><span class="fa  fa-user"></span> Users</a></li>
					<li class="{{( preg_match("#admin/analytics#i", Request::path()) ) ? 'active' : ''}}"><a href="/admin/analytics"><span class="fa fa-bar-chart-o"></span> Analytics</a></li>
					<li><a href="#"><span class="fa fa-calendar"></span> Calendar</a></li>
		        </ul>
		    </div>	       
	    </div>

      	<div style="width:800px; margin-left: 155px;">
        
         
          <!-- PAGE CONTENT -->

			@yield('content')      

          <!-- PAGE CONTENT -->
         
       <!-- /.row -->
       </div>
      </div><!-- /#page-wrapper -->

    <!-- /#wrapper -->





<?php /*



<div class="content_container container">
	
	<h3><i class="icon-magic"></i> Adminstration</h3>

	<div class="row">
		<div class="span3">
			<div class="well" style="padding: 8px 0;">
				<ul class="nav nav-list">
					<li class="{{( preg_match("#^admin^#i", Request::path()) ) ? 'active' : ''}}"><a href="/admin">Dashboard</a></li>

					<li ><a href="#">Inventory</a></li>

					<li class="nav-header">Users</li>
					<li><a href="#">Create new</a></li>
					<li class="{{( preg_match("#admin/users#i", Request::path()) ) ? 'active' : ''}}"><a href="/admin/users">Users list</a></li>

					<li class="nav-header">Inventory</li>
					<li><a href="#">Inventory</a></li>

				</ul>
			</div>
		</div>
		<div class="span9">
			@yield('content')
		</div>
	</div>	
</div>


<footer>
	&copy; 2013 by dxlab
</footer>
*/ ?>


</body>
</html>
