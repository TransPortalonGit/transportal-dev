<!-- REPLY-COMMENT -->
<div class="row" style="padding-top: 12px">
	<div class="commavatar col-md-2 col-md-push-1"> 
		<img src="/profile-pics/{{$comment->profile_pic}}" class="img-circle">
	</div>
	<div class="col-md-9 col-md-offset-1">
		<div class="commbubble">
			
			<div class="dashtop">
				<p>
					<a href="#">{{$comment->username}}</a>, in reply to {{$comments[$index-2]->username}}, said (<i>{{$comment->created_at}}</i>): 
					<span class="commnum"> #{{$index}} </span> 
				</p>
			</div>
			
			<div class="commbody">
				<p> 
					{{$comment->body}}
				</p>
			</div>
			
			<div class="dashbot">
				<a href="#" title="down vote"><i class="glyphicon glyphicon-minus-sign"></i></a>
				<font style="font-size: 15px"> {{$comment->up_votes}} </font>
				<a href="#" title="up vote"><i class="glyphicon glyphicon-plus-sign"></i></a>
				<span style="float: right"><button id="{{$index}}" class="reply_link" title="reply to username" onclick="$('#replytoreply_{{$index}}').toggle()"><i class="fa fa-mail-reply"> </i> Reply </button></span>
			</div>

		</div>
	</div>
</div>

<!-- REPLY TO REPLY-COMMENT -->
@if(Sentry::check())
	<div id="replytoreply_{{$index}}" hidden>
		<br />
		<form method="post" action="comment/{{$project->id}}" autocomplete="off" enctype="multipart/form-data">
		  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
		  <div class="row">
		    <div class="col-md-10 col-md-push-2">
		      <div class="form-group">
		        <textarea placeholder="{{Sentry::getUser()->username}} says..." rows="4" name="userComment" id="userComment" class="form-control mycommentbox" ></textarea>
		      </div>
		      <button type="submit" class="btn btn-success"> Submit </button>
		    </div>
		  </div>
		</form>
	</div>
@endif