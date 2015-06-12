<div class="thumbnail_shot col-xs-3 col-md-3">
  <a href="/project/{{$popProject->id}}" >
    <?php 
    $files = explode(",", $popProject->files);
    $file = $files[0];
    ?>
    @if(empty($file))
      <img src="/img/thumbnaildummy2.png">
    @else
      <img src="{{$file}}">
    @endif
      <div id="img_ribbon"> {{ $popProject->title }} </div>
  </a>

  <div class="caption_wrapper">         
    <ul class="caption">
      <li><i class="fa fa-calendar"></i> {{ date("d M. Y",strtotime($popProject->created_at)) }}</li>       
      <li><i class="fa fa-eye fa-lg" style="margin-left: 25px;"></i> {{ $popProject->views }} </li>
      <li><img src="/img/townmusiciansicon.png" alt="..."> {{ $popProject->favorite }}</li>
    </ul>
  </div>  
      
</div> 