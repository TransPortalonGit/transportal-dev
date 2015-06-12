@extends('layouts.master')

@section('content')
 <div id="browse-header" style="margin-top: 30px">
    
    <div id="project-sorter">
      <select class="form-control">
        <option>All</option>
        <option>Most recent</option>
        <option>Most comments</option>
        <option>Most favorites</option>
      </select>
    <div>
      <form class="navbar-form" role="search" style="display: inline; margin-left: : 20px;">
          <div class="form-group" >
             <input type="text" class="form-control" placeholder="Search" style="border-radius: 0; height: 32px;">
          </div>
            <button type="submit" class="btn btn-default">Submit</button>
      </form> 
      </div>       
    </div>
  </div>

 
    
  
  <!-- Popular project Thumbnails -->
  <div class="all_projects">

        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img src="img/thumb1.jpg"> 
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>


            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb2.jpg" style="z-index: -1">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

        <div class=" thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb3.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>
          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb4.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

        <!--A few row of thumbnail example -->
        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img src="img/thumb5.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb6.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>
          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

        <div class=" thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb7.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb8.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>


        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb8.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>


        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb8.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>



        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb8.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>


        <div class="thumbnail_shot col-sm-6 col-md-3">
          <a href="display_project_index.html" class="thumbnail">
            <img  src="img/thumb8.jpg">
            <div id="img_ribbon"> 3D glass for hipsters </div>

          </a>
            <div class="caption_wrapper">
              <ul class="caption">
                <li><i class="fa fa-eye"></i> 23 </li>
                <li><a href="#"><i class="fa fa-comment"></i> 6 </a></li>
                <li><a href="#"><i class="fa fa-heart"></i> 20 </a></li>
              </ul>
            </div>
        </div>

  </div>

  <div class="page_number"> 
    <ul class="pagination">
      <li><a href="#">&laquo;</a></li>
      <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li><a href="#">&raquo;</a></li>
    </ul>
  </div>
    <!--Thumbnails end here -->
    
 
  
	
@stop