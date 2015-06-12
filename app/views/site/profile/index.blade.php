@extends('layouts.master')

@section('head')

{{ HTML::script('js/listings.js'); }}
{{ HTML::style('css/listings.css'); }}
@include('site/partials/_tags-head')

@stop

@section('content')



	
		
		<div class="content_container container">
			@include('site.profile._user_profileheader')


			@if (Sentry::Check() && Sentry::getUser()->username == $username)
				@include('site.profile._user_navigation')
			@endif

			<!--This is the My Recent Projects of dashboad page-->
			<div>
				<div style="margin-top:10px; font-weight: bold">
				    <p> My Recent Projects</p>
				    <hr>
				</div>

				<!-- Project Thumbnails -->			
				
				<div class="low  row" style="margin:0;" >
				    <div class="all_projects" >
				      <!--single thumbnail-->
				        @foreach($projects->slice(-4, 4) as $project)
							
						        @include('partials._projectpreview') 
						  	
				  		@endforeach
						
					   <!--/single thumbnail-->	      
					</div>
  				</div> 
			</div>

			<!--This is the My Favorite Projects of dashboad page-->
			<div>
				<div style="margin-top:10px; font-weight: bold">
				    <p> Recently Favorited Projects</p>
				    <hr>
				</div>		
				
				<div class="low  row" style="margin:0;" >
				    <div class="all_projects" >
				    	@if(count($usersfavorites) <= 4)
					        @for($i=0;$i<count($usersfavorites);$i++)
							
								<div class="thumbnail_shot col-xs-3 col-md-3">
								  <a href="/project/{{$usersfavorites[$i]->project_id}}" >
								    <?php 
								    $files = explode(",", $usersfavorites[$i]->files);
								    $file = $files[0];
								    ?>
								    @if(empty($file))
								    <img src="/img/thumbnaildummy2.png">
								    @else
								    <img src="{{$file}}">
								    @endif
								    <div id="img_ribbon"> {{ $usersfavorites[$i]->title }} </div>
								  </a>
								    <div class="caption_wrapper">         
								      <ul class="caption"> 
								        <li><i class="fa fa-calendar"></i> {{ date("d M. Y",strtotime($usersfavorites[$i]->created_at)) }}</li>        
								        <li><i class="fa fa-eye fa-lg" style="margin-left: 25px;"></i> {{ $usersfavorites[$i]->views }} </li>
								        <li><img src="/img/townmusiciansicon.png" alt="..."> {{ $usersfavorites[$i]->favorite }}</li>
								      </ul>
								  </div>      
								</div>
			
						  	@endfor

					  	@elseif(count($usersfavorites) > 4)
					    	@for($i=0;$i<4;$i++)
						
								<div class="thumbnail_shot col-xs-3 col-md-3">
								  <a href="/project/{{$usersfavorites[$i]->project_id}}" >
								    <?php 
								    $files = explode(",", $usersfavorites[$i]->files);
								    $file = $files[0];
								    ?>
								    @if(empty($file))
								    <img src="/img/thumbnaildummy2.png">
								    @else
								    <img src="{{$file}}">
								    @endif
								    <div id="img_ribbon"> {{ $usersfavorites[$i]->title }} </div>
								  </a>
								    <div class="caption_wrapper">         
								      <ul class="caption"> 
								        <li><i class="fa fa-calendar"></i> {{ date("d M. Y",strtotime($usersfavorites[$i]->created_at)) }}</li>        
								        <li><i class="fa fa-eye fa-lg" style="margin-left: 25px;"></i> {{ $usersfavorites[$i]->views }} </li>
								        <li><img src="/img/townmusiciansicon.png" alt="..."> {{ $usersfavorites[$i]->favorite }}</li>
								      </ul>
								  </div>      
								</div>

					  		@endfor

				  		@endif

					</div>
  				</div> 
			</div>
		
			

			</div>
		</div>
		
<script type="text/javascript">
    (function(){
        setAutoSubmit();
    })();
</script>

@stop