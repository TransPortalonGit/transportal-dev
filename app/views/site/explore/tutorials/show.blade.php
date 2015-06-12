@extends('layouts.master')


@section('head')

<style type="text/css">
@media screen and (max-width: 767px) {
	body {
		margin-top: 130px;
	}
}
</style>
<script type="text/javascript">

$(document).ready(function(){
	
	$("#sectionbar .nav > li > a.goto").bind("click", function(event) {
		event.preventDefault();
		var target = $(this).attr("href");
		$('html,body').animate({
			scrollTop: $(target).offset().top - 90
		}, 300 , function (){
			location.hash = target;
		});
    });
        
	$("body").scrollspy({
	    target : '#sectionbar',
	    offset : 90
	});
	
});

</script>

@stop
@section('content')
	<div class="visible-phone" style="z-index: 100; background: #f0f0f0; padding: 10px; border-bottom: solid 1px #ddd; position: fixed; top: 70px; left: 0px; right: 0px;">
		<select class="span12" style="margin: 0;">
			<option value="#abstract">Abstract</a>
			<?php
			for ($a=1; $a<= count($steps); $a++) {
				echo '<option value="#section'.$a.'">'.$a.': '. $headings[$a-1].'</option>';
			}
			?>
		</select>
	</div>
	
	<div class="row">

		<div id="sectionbar" class="span3 hidden-phone">
			<ul class="span3 nav nav-tabs nav-stacked affix" style="margin:0" >
				<li class="active"><a href="#abstract" class="goto"><i class="icon-bookmark"></i> Abstract<i class="icon-chevron-right"></i></a></li>
				<li class="divider"></li>
				<?php
				for ($a=1; $a<= count($steps); $a++) {
					echo '<li><a href="#section' . $a . '" class="goto"> ' . $a . ': ' . $headings[$a-1] . '<i class="icon-chevron-right"></i></a></li>';
				}
				?>
			</ul>
		</div>
		<div class="span9" id="tutorial">
			<section id="abstract">
				<div class="shield">
					<h1>{{$tutorial->title}}</h1>
					@if (Sentry::check() && Sentry::getUser()->hasAccess('is_admin'))
					<a href="/tutorials/edit/{{$tutorial->id}}" class="btn btn-admin"><i class="icon-pencil"></i></a>
					@endif
				</div>
			<p class="lead">{{$tutorial->description}}</p>

			<hr />
			</section>
			
			<?php $step_id = 1;?>
			@foreach ($steps as $step)
			<section>
				<div id="section{{$step_id}}"></div>
				{{$step}}
				<?php $step_id++;?>
			</section>
			@endforeach

		</div>
		
	</div>
@stop