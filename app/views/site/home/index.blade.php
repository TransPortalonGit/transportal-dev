@extends('layouts.master')

@section('content')


<div class="wrapper">    
  <div id="header-carousel"> 
    
    <div id="myCarousel" class="carousel slide">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      </ol>

      <!-- Carousel items -->
      <div class="carousel-inner">
        
        <div class="item">
          <a href="latestnews/news"><img src="/img/slideshow/01.jpg"> </a>
        </div>
        
        <div class="item active">
          <a href="explore/tutorials"><img src="/img/slideshow/fablab_door_photo_edit.jpg"> </a>
        </div>
        
        <div class="item">
          <a href="explore/tutorials"><img src="/img/slideshow/03.jpg"> </a>
        </div>
      
      </div>

      <div class="controller">
          <a class=" carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
          <a class=" carousel-control right" href="#myCarousel" data-slide="next">›</a>
      </div>

    </div>
  </div>
    
  <div id="content-body">
    <div id="left-col">
      <div class="left-box-contents">

        <div class="left-box-item" id="site-news">
          <div class="left-box-label"><p>LATEST NEWS</p></div> 

          <div class="wikinews">
            <p>WORDPRESS BLOG:</p>
          </div>

          <script type="text/javascript">
            document.write('<script type="text/javascript" src="' + ('https:' == document.location.protocol ? 'https://' : 'http://') + 'feed.mikle.com/js/rssmikle.js"><' + '/script>');
          </script>
          
          <script type="text/javascript">(function() {var params = {rssmikle_url: "http://www.fablab-bremen.org/feed/",rssmikle_frame_width: "208",rssmikle_frame_height: "125",rssmikle_target: "_blank",rssmikle_font: "sans-serif",rssmikle_font_size: "12",rssmikle_border: "off",responsive: "off",rssmikle_css_url: "",text_align: "left",text_align2: "left",corner: "off",scrollbar: "off",autoscroll: "off",scrolldirection: "up",scrollstep: "3",mcspeed: "20",sort: "New",rssmikle_title: "off",rssmikle_title_sentence: "",rssmikle_title_link: "",rssmikle_title_bgcolor: "#34A26A",rssmikle_title_color: "#FFFFFF",rssmikle_title_bgimage: "",rssmikle_item_bgcolor: "#FFFFFF",rssmikle_item_bgimage: "",rssmikle_item_title_length: "55",rssmikle_item_title_color: "#34A26A",rssmikle_item_border_bottom: "on",rssmikle_item_description: "title_only",item_link: "off",rssmikle_item_description_length: "150",rssmikle_item_description_color: "#666666",rssmikle_item_date: "gl2",rssmikle_timezone: "Europe/Berlin",datetime_format: "%b %e, %Y %l:%M:%S %p",item_description_style: "text",item_thumbnail: "full",article_num: "2",rssmikle_item_podcast: "off",keyword_inc: "",keyword_exc: ""};feedwind_show_widget_iframe(params);})();
          </script>

          <div class="wikinews">
            <p>WIKI POSTS:</p>
          </div>

          <script type="text/javascript">
              document.write('<script type="text/javascript" src="' + ('https:' == document.location.protocol ? 'https://' : 'http://') + 'feed.mikle.com/js/rssmikle.js"><' + '/script>');
            </script>
            
            <script type="text/javascript">(function() {var params = {rssmikle_url: "http://www.fablab-bremen.org/wiki/feed",rssmikle_frame_width: "208",rssmikle_frame_height: "110",rssmikle_target: "_blank",rssmikle_font: "sans-serif",rssmikle_font_size: "12",rssmikle_border: "off",responsive: "off",rssmikle_css_url: "",text_align: "left",text_align2: "left",corner: "off",scrollbar: "off",autoscroll: "off",scrolldirection: "up",scrollstep: "3",mcspeed: "20",sort: "New",rssmikle_title: "off",rssmikle_title_sentence: "",rssmikle_title_link: "",rssmikle_title_bgcolor: "#34A26A",rssmikle_title_color: "#FFFFFF",rssmikle_title_bgimage: "",rssmikle_item_bgcolor: "#FFFFFF",rssmikle_item_bgimage: "",rssmikle_item_title_length: "55",rssmikle_item_title_color: "#34A26A",rssmikle_item_border_bottom: "on",rssmikle_item_description: "title_only",item_link: "off",rssmikle_item_description_length: "150",rssmikle_item_description_color: "#666666",rssmikle_item_date: "gl2",rssmikle_timezone: "Europe/Berlin",datetime_format: "%b %e, %Y %l:%M:%S %p",item_description_style: "text",item_thumbnail: "full",article_num: "2",rssmikle_item_podcast: "off",keyword_inc: "",keyword_exc: ""};feedwind_show_widget_iframe(params);})();
            </script>
            
            <div style="font-size:10px; text-align:center; width:208;">
              <a href="http://feed.mikle.com/" target="_blank" style="color:#CCCCCC;">RSS Feed Widget</a>
            </div>
        </div>

          <div  class="left-box-item" id="open-hours">
            <div class="left-box-label"><p>OPEN LAB DAY</p></div>          
            <p style="padding-left: 10px; font-size: 12px;">
              Monday: 18:00 - 21:00 
              <br>
            </p>
          </div>

          <div  class="left-box-item" id="contact-us">
            <div class="left-box-label"><p>CONTACT US</p></div>
              <p style="padding-left: 10px; font-size: 12px;">
                E-Mail: <a href="mailto:info@fablab-bremen.org" target="_top">
                info(at)fablab-bremen.org</a>
              </p> 
          </div>

          <div class="left-box-item" id="whos-in-lab">
            <div class="left-box-label"><p>IN LAB RIGHT NOW</p></div>           
            <ul class="media-list " style="height: 150px; overflow: scroll; padding-left: 10px; font-size: 13px;">

              @if($usersinlab)
                @foreach($usersinlab as $userinlab)
                  @if($userinlab->incognito == 0) 
                  <li style="width: 100%; display: inline-block;">
                    <a  href="/profile/show/{{ $userinlab->username }}" title="Go to {{ $userinlab->username }} profile">
                      <img  alt="" style="width: 20px; height: 20px;" src="/profile-pics/{{$userinlab->profile_pic}}">
                      <div style="width: 100px; display: inline-block;">
                      <p>{{ $userinlab->username }}</p>   
                      </div>
                     </a>
                  </li>           
              @endif
                @endforeach
              @else
                    <p>{{ $userinlab->username }} The lab is empty. :(</p>
              
              @endif
              
            </ul>
     
          </div>
        </div>
      </div>

      <div id="right-col">
        <div class="big-quick-panel">
          <div id="container">
            <div class="panel-item" id="browse" title="browse public projects">
              <a href="/explore/publicprojects">
                <div><i class="fa fa-eye"></i> Be Inspired!</div>
                <div>Browse best collections of projects</div>
              </a>
            </div>
            <div class="panel-item" id="machine-info" title="read about fablab tools">
              <a href="/explore/tools">
                <div><i class="fa fa-book"></i> Learn It!</div>
                <div>Read how those fancy machines works</div>
              </a>
            </div>
            <div class="panel-item" id="insurance" title="Liability Insurance">
              <a href="/uploads/files/Studentische_Haftpflichtversicherung_Infoblatt.pdf" target="_blank">
                <div><i class="fa fa-exclamation-circle"></i> Be Insured!</div>
                <div>Some insurance requirement to use lab tools</div>
              </a>
            </div>
              <span class="stretch"></span>
          </div>
        </div>

        <i class="glyphicon glyphicon-bookmark"></i><strong> Latest Projects</strong>
        <hr>
          <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
            <div class="row-fluid">
              <div class="all_projects">

                @foreach($projects as $project)
                         
                  @include('partials._projectpreview')
                           
                @endforeach 

              </div>
            </div>
          </div>

        <br />

        <i class="glyphicon glyphicon-bookmark"></i><strong> Popular Projects</strong>
        <hr>
          
          <div class="all_projects">

            @foreach($popProjects as $popProject)
                         
                @include('partials._popProjectpreview')
                           
            @endforeach 

          </div>

      </div>
 
    </div>    
</div>

@stop