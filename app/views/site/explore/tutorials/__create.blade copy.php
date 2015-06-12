@extends('layouts.master')

@section('page_header')
	<i class="icon-book"></i> <a href="/tutorials">Tutorials</a> <i class="icon-angle-right"></i> Create new tutorial
@stop

@section('head')
{{HTML::script('/js/jquery-ui.min.js')}}
{{HTML::script('/js/nicedit.js')}}

{{HTML::style('/css/bootstrap-fileupload.min.css')}}
{{HTML::script('/js/bootstrap-fileupload.min.js')}}

	<style type="text/css">
		
		#sidenav button.btn {
			width: 45px;
			margin-bottom: 10px;
		}
	

textarea{
	resize: vertical;
}
	
#transaction-items {
	border: solid 1px rgb(204, 204, 204);
	min-height: 200px;
	padding: 0;
	margin-bottom: 25px;
}

.transaction-item {
	border-bottom: solid 1px #ccc;
	background:  #f0f0f0;
	padding-top: 5px;
	padding-bottom: 5px;
}

.transaction-item:last-child {
	border: 0;
}

.transaction-item .control {
	padding: 5px;
	padding-left: 0;
	line-height: 44px;
}

.transaction-item .control a {
	color: #aaa;
	text-decoration: none;
	margin-left: 10px;
}

.transaction-item .textarea-wrapper {
	padding-left: 10px;
	padding-right: 10px;
	padding-bottom: 5px;
}

.transaction-item .textarea-wrapper textarea {
	width: 100%;
	height: 200px;
	border: solid 1px #ccc;
}

.nicEdit-main {
	border: solid 1px #ccc;;
}

.btn-group > .btn:first-child , .btn-group > .btn {
	margin-right: 5px;
}

.btn-group, .btn-group + .btn-group {
	margin: 0px;
	line-height: 30px;
}

.affix {
	top: 100px;
	z-index: 1000;
}


</style>

<script type="text/javascript">

var anz = 0;
var uid = 0;



function init_sortable() {
	$("#transaction-items").sortable({
		handle : 'div a.sort'
	});
}


function add_text() {

	uid = uid + 1;
	anz = anz + 1;
	//document.maske.anz.value = anz;
	
	output = '<div id="item'+uid+'" class="transaction-item">';
	
	output += '<div class="control pull-left">';
	output += '<a href="#:" class="sort"><i class="icon-reorder icon-big"></i></a>';
	output += '<a href="#:" class="del" onclick="remove_entry(this)"><i class="icon-remove icon-red icon-big"></i></a>';
	output += '</div>';

	output += '<div class="textarea-wrapper">';

	output += '<input type="hidden" name="item_id[]" value="" />';

	output += '<textarea id="item_text'+uid+'" name="text[]" value="" />';
	output += '</div>';
	
	$('#transaction-items').append(output);
		
	init_sortable();
//	nicEditors.allTextAreas();
	new nicEditor().panelInstance('item_text'+uid);	
}

function show_preview(item_id) {
	$('#item_preview'+item_id).show();
}
function hide_preview(item_id) {
	$('#item_preview'+item_id).hide();
}

function add_image() {

	uid = uid + 1;
	anz = anz + 1;
	//document.maske.anz.value = anz;
	
	output = '<div id="item'+uid+'" class="transaction-item">';
	
	output += '<div class="control pull-left">';
	output += '<a href="#:" class="sort"><i class="icon-reorder icon-big"></i></a>';
	output += '<a href="#:" class="del" onclick="remove_entry(this)"><i class="icon-remove icon-red icon-big"></i></a>';
	output += '</div>';

	output += '<div class="textarea-wrapper">';

	output += '<input type="hidden" name="item_id[]" value="" />';

	output +='<div class="fileupload fileupload-new" data-provides="fileupload">';
	output +='<div style="line-height: 44px;">';
	output +='<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="item_image[]" id="item_image'+uid+'"  accept="image/*" onchange="show_preview('+uid+')"/></span>';
	output +='<a href="#:" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>';
	output +='</div>';
	output +='<div id="item_preview'+uid+'"class="fileupload-preview thumbnail" style="display: none"></div>';
	
	output +='</div>';
	
	output += '<div class="clearfix"></div>';
	output += '</div>';
	
	$('#transaction-items').append(output);
		
	init_sortable();
}



function remove_entry(id) {
	$(id).parent().parent().remove();
	anz = anz -1;
	//document.maske.anz.value = anz;
}




//----------------------------------------------------//


$(document).ready(function () {
	init_sortable();
	
	//nicEditors.allTextAreas();
	//	$('.transaction-item textarea').niceditor();

    
});

</script>



@stop

@section('content')
{{Form::open()}}

{{Form::hidden('anz', '')}}

<div class="well">
	<div class="row">
		<div class="span10 offset1">
			
			{{Form::text('title', '', array(
				'placeholder' => 'Title',
				'class' => 'span10',
			));}}

			{{Form::textarea('description', '', array(
				'placeholder' => 'Description',
				'class' => 'span10',
			));}}
		</div>
	</div>
	<div class="row">
		<div class="span1" id="sidenav">
			<div data-spy="affix" data-offset-top="335" class="span1" style="margin:0">
				<button type="button" onclick="add_text();" class="btn btn-primary"><i class="icon-font icon-big"></i></button>
				<button type="button" onclick="add_image();" class="btn btn-primary"><i class="icon-picture icon-big"></i></button>
				<button type="button" onclick="add_document();" class="btn btn-primary"><i class="icon-file-alt icon-big"></i></button>
			</div>
		</div>	
		<div class="span10">
			<div class="transaction-items ui-sortable" id="transaction-items">
								
			</div>	
			
			

			
			
			

			<input type="submit" value="Save tutorial" class="btn btn-primary">
		</div>
		
	</div>
</div>
	{{Form::close()}}


<?php 
/*
			<canvas id="my-canvas" width="700" height="600">I am canvas</canvas>


<script>
					(function () {
						var canvas = document.getElementById("my-canvas"),
							context = canvas.getContext("2d"),
							img = document.createElement("img"),
							mouseDown = false,
							brushColor = "rgb(240, 0, 0)",
							hasText = true,
							clearCanvas = function () {
								if (hasText) {
									context.clearRect(0, 0, canvas.width, canvas.height);
									hasText = false;
								}
							};
							
						// Adding instructions
						context.fillText("Drop an image onto the canvas", 240, 200);
						context.fillText("Click a spot to set as brush color", 240, 220);
						
						// Image for loading	
						img.addEventListener("load", function () {
							clearCanvas();
							context.drawImage(img, 0, 0);
						}, false);
						
						// Detect mousedown
						canvas.addEventListener("mousedown", function (evt) {
							clearCanvas();
							mouseDown = true;
							context.beginPath();
						}, false);
						
						// Detect mouseup
						canvas.addEventListener("mouseup", function (evt) {
							mouseDown = false;
						}, false);
						
						canvas.addEventListener("mousemove", function (evt) {
							if (mouseDown) {
								context.strokeStyle = brushColor;								
								context.lineWidth = 5;
								context.lineJoin = "round";
								context.lineTo(evt.layerX+1, evt.layerY+1);
								context.stroke();
							}
						}, false);

						canvas.addEventListener("dragover", function (evt) {
							evt.preventDefault();
						}, false);

						canvas.addEventListener("drop", function (evt) {
							var files = evt.dataTransfer.files;
							if (files.length > 0) {
								var file = files[0];
								if (typeof FileReader !== "undefined" && file.type.indexOf("image") != -1) {
									var reader = new FileReader();
									reader.onload = function (evt) {
										img.src = evt.target.result;
									};
									reader.readAsDataURL(file);
								}
							}
							evt.preventDefault();
						}, false);
						
						var saveImage = document.createElement("button");
						saveImage.innerHTML = "Save canvas";
						saveImage.addEventListener("click", function (evt) {
							window.open(canvas.toDataURL("image/png"));
							evt.preventDefault();
						}, false);
						document.getElementById("main-content").appendChild(saveImage);
					})();
				</script>
*/
?>

@stop