<div class="profile_header">
	<div class="row">
		<div class= "brief_profile">
			@if (Sentry::Check() && Sentry::getUser()->username == $user->username)
				<a href="/profile/setting"> <img src="/profile-pics/{{$user->profile_pic}}" height="89px" width="89px" class="img-responsive img-thumbnail" alt="Responsive image" ></a>
			@else
				<a href=#><img src="/profile-pics/{{$user->profile_pic}}" height="89px" width="89px" class="img-responsive img-thumbnail" alt="Responsive image" ></a>
			@endif
		</div>
		<div class="bio">
			<h5><strong>{{ strtoupper($user->username)}}  </strong>
				@if (Sentry::Check() && Sentry::getUser()->username == $user->username)
					<a href="/profile/setting"><i class="fa fa-pencil-square-o"></i></a>
				@endif
			</h5>
			@if($user->city && $user->city != " ")
  			    <small>{{$user->zipcode}} {{$user->city}} <a href="/profile/passwordchange"></a></small><br>
  			@endif
  			@if($user->company && $user->company != " ")
  			    <small>{{$user->company}} <a href="/profile/passwordchange"></a></small><br>
  			@endif
	  		@if($user->description && $user->description != " ")
		  		<small>{{$user->description}}</small>
	  		@endif
	  		@if (Sentry::Check())
		  		@if($user->homepage && $user->homepage != " ")
		  			<a href="{{$user->homepage}}" target= "_blank" ><small title="Homepage">My Homepage </small></a>
		  		@endif
		  		<br>
		  		@if($user->email && $user->email != " ")
		  		<a href="mailto:{{$user->email}}"><i class="fa fa-envelope" title="Email"></i></a> 
		  		@endif
		  		@if($user->facebook && $user->facebook != " ")
		  			<a href="{{$user->facebook}}" target="_blank" ><i class="fa fa-facebook-square" title="Facebook"></i></a>
		  		@endif
		  		@if($user->twitter && $user->twitter != " ")
		  			<a href="{{$user->twitter}}" target="_blank"><i class="fa fa-twitter" title="Twitter"></i></a>
		  		@endif
		  		@if($user->googleplus && $user->googleplus != " ")
		  			<a href="{{$user->googleplus}}" target="_blank"><i class="fa fa-google-plus" title="Google+"></i></a>
		  		@endif
	  			@if($user->academia && $user->academia != " ")
		  			<a href="{{$user->academia}}" target="_blank"><i class="fa fa-graduation-cap" title="Academia.edu"></i></a>
	  			@endif
	  			@if($user->linkedin && $user->linkedin != " ")
		  			<a href="{{$user->linkedin}}" target="_blank"><i class="fa fa-linkedin" title="LinkedIn"></i></a>
	  			@endif
	  			@if($user->github && $user->github != " ")
		  			<a href="{{$user->github}}" target="_blank"><i class="fa fa-github-alt" title="Github"></i></a>
	  			@endif
	  			@if($user->threedplatform && $user->threedplatform != " ")
		  			<a href="{{$user->threedplatform}}" target="_blank"><i class="fa fa-cube" title="3D-Platform"></i></a>
	  			@endif
	  		@endif

	  	</div>
	</div>
</div>
