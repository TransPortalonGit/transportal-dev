<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	
	<title>TransPortal</title>

	@include('layouts._head')

	@yield('head')

</head>
<body>
		

      <nav class="navbar navbar-default navbar-fixed-top " role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->

        <div class="header-wrapper ">
        	
		        <div class="navbar-header ">
		          	<button  class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-main-collapse">
		            	<span class="sr-only">Toggle navigation</span>
		            	<span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			        </button>
		          
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="container">
						<a  class="navbar-brand logo" href="/home">
		          		<img src="/img/transportalLogo.png" />
						</a>
				        <div class="collapse navbar-collapse navbar-main-collapse"  >
				            <ul class="nav navbar-nav navbar-right">
							@include('layouts._navigation')
				          	</ul>
				        </div><!-- /.navbar-collapse -->
			        </div>
		        </div>      
			</div>	        
      
      </nav>

<div class="content_container container">
	@yield('content')	
</div>


<footer>
	@include('layouts._footer')
</footer>

</body>
</html>
