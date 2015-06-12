<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	
	<title>TransPortal - Administration</title>

	@include('layouts._head')
	@yield('head')

	{{HTML::style('/css/sb-admin.css')}}
  <script type="text/javascript">
  $(document).ready(function(){
    $("#dashboard-card, #calendar-card, #user-card, #analytic-card,#inventory-card").addClass("visible");
  });

  

  </script>
	

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
        
<style type="text/css">
  #dashboard-card, #inventory-card, #user-card, #analytic-card, #calendar-card {
    background-color: #ffffff;

    position: absolute;
    top: -25px;
  
    transition: top 0.8s;
    -moz-transition: top 0.8s;
    -webkit-transition: top 0.8s;
    -o-transition: top 0.8s;
}

  #dashboard-card.visible {
      top: 200px;
  }
  #inventory-card.visible {
      top: 200px;
      margin-left: 340px;
      
  }
  #user-card.visible {
      top: 380px;
     
  }
  #analytic-card.visible {
      top: 380px;
      margin-left: 340px;

  }
  #calendar-card.visible {
      top: 380px;
      margin-left: 170px;

      
  }
  .top-row, .bottom-row {
    width: 100%;
   
    
    display: inline;
  }
  #dashboard-card {
    width: 330px;
    height: 160px;
    border: 1px solid #ddd;
    display: inline;
    padding-top: 50px;
   
    text-align: center;
    
  }
  #inventory-card, #user-card, #calendar-card, #analytic-card {
    width: 160px;
    height: 160px;
    border: 1px solid #ddd;
    display: inline;
    text-align: center;
    padding-top: 50px;
    

  }
  .top-row a, .bottom-row a {
    color: #34a26a;
  }
  .top-row a:hover, .bottom-row a:hover {
    color:  #1A7C4A;
  }
  .card-wrapper {
    position: relative;
    padding-left: 20%;
    padding-right: 20%;
  }

  #card-name {
  position: absolute; 
  width: inherit;
  top: 150px; 
  color: #ffffff; 
  margin:0;
  padding:0; 
  background-color: #525252;
  
  }

  .card-wrapper .top-row div:hover div#card-name, .card-wrapper .bottom-row div:hover div#card-name {
    display: block;

  }
</style>
    <div class="card-wrapper">
      <div class="top-row">
       <a href="/admin/dashboard">        
          <div id="dashboard-card">
            <div class="card-frame">            
             <i class="fa fa-tachometer fa-4x"></i>
            </div>
            <div id="card-name" ><strong>DASHBOARD</strong></div>
          </div>
        </a>
        <a href="/admin/inventory">
          <div id="inventory-card">
            <div class="card-frame"> 
            <i class="fa fa-table fa-4x"></i>
          </div>
            <div id="card-name"><strong>INVENTORY</strong></div>
          </div>
        </a>     
      </div>
      <div class="bottom-row"> 
        <a href="/admin/users">       
          <div id="user-card">
            <div class="card-frame"> 
            <i class="fa fa-user fa-4x" ></i></div>
            <div id="card-name"><strong>USERS</strong></div>
          </div>
        </a>
        <a href="/admin/analytics">
          <div id="analytic-card">       
            <div class="card-frame"> 
            <i class="fa fa-bar-chart-o fa-4x"></i></div>
            <div id="card-name"><strong>ANALYTICS</strong></div>
          </div>
        </a> 
        <a href="#">     
          <div id="calendar-card">
            <div class="card-frame">             
            <i class="fa fa-calendar fa-4x"></i>
            </div>        
            <div id="card-name"><strong>CALENDAR</strong></div>          
          </div> 
        </a>     
      </div>
    </div>



       <!--/testing contents-->

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
