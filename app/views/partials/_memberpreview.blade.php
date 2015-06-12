<div class="thumbnail_shot col-xs-3 col-md-3" @if($user->Role == "1") style="background-color: #fffce0" @endif>
  <a href="/profile/show/{{$user->username}}" >
    <img src="/profile-pics/{{$user->profile_pic}}">
    <div id="img_ribbon"> {{ $user->username }} </div>
  </a>
  <div class="caption_wrapper">
      @if($user->Role == "1")
      <span class="admin_badge"><i class="glyphicon glyphicon-certificate"></i>admin</span>
      @endif
    <ul class="caption">
      <li><a href="#" title="chat with {{$user->username}}"><i class="fa fa-weixin fa-2x"></i></a></li>
    </ul>
  </div>      
</div>