@extends('layouts.master')

@section('head')

{{HTML::style('/css/project.css')}}

{{HTML::style('/css/redactor.css')}}
{{HTML::style('/css/redactor.bootstrap.css')}}
{{HTML::script('/js/redactor.min.js')}}
{{HTML::script('/js/projects--create.js')}}				<!-- HIER -->

{{HTML::style('/css/bootstrap-fileupload.min.css')}}
{{HTML::script('/js/bootstrap-fileupload.min.js')}}


<script type="text/javascript">

function delete_session() {
    bootbox.confirm("<h3>Do you really want to delete this workstep?</h3>", function(result) {
        if (result) {
            $('#deleteForm').submit();
        }
    }); 
}

var icid = 1;

$(document).ready(function(){

	/*$('#step').focus(function(){
		$("#step ~ span").fadeToggle();
	});

	$('#step').blur(function(){
		$("#step ~ span").fadeToggle();
	});*/

	$("input, textarea").focus(function(){
		$(this).parent().siblings("div").children("span").fadeToggle();
        $(this).trigger('keyup');
	})

	$("input, textarea").blur(function(){
		$(this).parent().siblings("div").children("span").fadeToggle();
	})

    $("textarea").keyup(function(){
        $this = $(this); // Input, in den getippt wird

        var currentLength = $this.val().length;
        var maxLength = $this.attr('maxlength');

        $('.infobox').text(currentLength + ' of ' + maxLength + ' characters used');
    });

});

$(function(){
	$('#redactor_content').redactor({
		imageUpload: '/projects/imageupload',
		//fileUpload: '/projects/fileupload',
		//imageGetJson: '/projects/getjson',
		//linebreaks: true,
		paragraphy: false,
		toolbarFixed: false,
		toolbarFixedTopOffset: 75, 
		buttons: ['bold', 'italic', 'underline', '|',
'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'html' ],
		wym: false,
	    allowedTags: ['p', 'b', 'strong', 'i', 'u', 'ul', 'ol', 'li', 'dl', 'dt', 'dd'],

		//formattingTags: ['h2', 'h3', 'p' ],
		langs: {
				en: {
					html: 'HTML',
					video: 'Insert Video',
					image: 'Insert Image',
					link: 'Link',
					link_insert: 'Insert link',
					unlink: 'Unlink',
					formatting: 'Formatting',
					paragraph: 'Normal text',
					quote: 'Quote',
					code: 'Code',
					header2: 'Section',
					header3: 'Heading',
					bold: 'Bold',
					italic: 'Italic',
					unorderedlist: 'Unordered List',
					orderedlist: 'Ordered List',
					outdent: 'Outdent',
					indent: 'Indent',
					cancel: 'Cancel',
					insert: 'Insert',
					save: 'Save',
					_delete: 'Delete',
					rows: 'Rows',
					columns: 'Columns',
					add_head: 'Add Head',
					delete_head: 'Delete Head',
					title: 'Title',
					image_position: 'Position',
					none: 'None',
					left: 'Left',
					right: 'Right',
					image_web_link: 'Image Web Link',
					text: 'Text',
					mailto: 'Email',
					web: 'URL',
					video_html_code: 'Video Embed Code',
					file: 'Insert File',
					upload: 'Upload',
					download: 'Download',
					choose: 'Choose',
					or_choose: 'Or choose',
					drop_file_here: 'Drop file here',
					align_left: 'Align text to the left',
					align_center: 'Center text',
					align_right: 'Align text to the right',
					align_justify: 'Justify text',
					horizontalrule: 'Add Section',
					deleted: 'Deleted',
					anchor: 'Anchor',
					link_new_tab: 'Open link in new tab',
					underline: 'Underline',
					alignment: 'Alignment',
					filename: 'Name (optional)',
				}
		},
		
	});
});

function remove_image(id) {
	$(id).parent().remove();
/*
	$('#icid-' + id).fileupload('clear');
	$('#icid-' + id).remove();
	*/
}

function remove_image2(id) {
	$(id).parent().remove();
}

function add_image() {
	var output = "";
	output += '<div class="pull-left image-container">';
	output += '<div class="fileupload fileupload-new" data-provides="fileupload">';
	output += '<div class="fileupload-new thumbnail"><i class="fa fa-picture-o"></i></div>';
	output += '<div class="fileupload-preview fileupload-exists thumbnail"></div>';
	output += '<br />';
	output += '<span class="btn btn-file"><span class="fileupload-new"><i class="fa fa-upload"></i></span><span class="fileupload-exists">Change</span><input type="file" name="file[]" /></span>';
	output += ' <button type="button" onclick="remove_image(this);" class="btn btn-danger" title="Remove photo"><i class="fa fa-trash-o"></i></button>';
	output += '</div>';
	output += '</div>';
	$('#add-image-btn').before(output);
	icid++;
}

function add_file() {
	var output = "";
	output += '<div class="pull-left image-container">';
	output += '<div class="fileupload fileupload-new" data-provides="fileupload">';
	output += '<div class="fileupload-new thumbnail"><i class="fa fa-file-text-o"></i></div>';
	output += '<div class="fileupload-preview fileupload-exists thumbnail"></div>';
	output += '<br />';
	output += '<span class="btn btn-file"><span class="fileupload-new"><i class="fa fa-upload"></i></span><span class="fileupload-exists">Change</span><input type="file" name="doc[]" /></span>';
	output += ' <button type="button" onclick="remove_image(this);" class="btn btn-danger" title="Remove photo"><i class="fa fa-trash-o"></i></button>';
	output += '</div>';
	output += '</div>';
	$('#add-file-btn').before(output);
	icid++;
}


</script>
        
@stop

@section('content')
	@if($errors->first('projectid')) 
		<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
		@foreach ($errors->get('projectid') as $error)
			{{ $error }}
		@endforeach
		</p>
	@endif
@include('site/listings/partials/_form-header', ['title' => 'Edit your Workstep'])

{{ Form::model ($projectsession, array('method' => 'PATCH', 'enctype' => "multipart/form-data", 'action' => ['ProjectSessionController@update', $projectsession->id], 'class' => 'form-horizontal'))}}
 
{{ Form::hidden('project_id', $projectsession->project->id)}}

<div class="form-group required">

	{{ Form::label('step', 'Step:', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-5">
		{{ Form::text('step', null, array('class' => 'form-control input-sm')) }}
	@if($errors->first('step')) 
		<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
		@foreach ($errors->get('step') as $error)
			{{ $error }}
		@endforeach
		</p>
	@endif
	</div>
	<div class="col-sm-5">
		<span style="display:none; color:#999;"><small>Name your working step. In a short term: What did you do?</small></span>
	</div>

</div>

<div class="form-group">
	{{ Form::label('duration', 'Duration:', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-5">
	{{ Form::text('duration', null, array('class' => 'form-control input-sm')) }}
	@if($errors->first('duration')) 
		<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
		@foreach ($errors->get('duration') as $error)
			{{ $error }}
		@endforeach
		</p>
	@endif
	</div>
	<div class="col-sm-5">
	<span style="display:none; color:#999;"><small>How much time did you spend in the FabLab?</small></span>
	</div>
</div>

<div class="form-group">
	{{ Form::label('technology', 'Technology:', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-5">
		{{ Form::text('technology', null, array('class' => 'form-control input-sm'))}}
		@if($errors->first('technology')) 
			<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
			@foreach ($errors->get('technology') as $error)
				{{ $error }}
			@endforeach
			</p>
		@endif
		</div>
	<div class="col-sm-5">
	<span style="display:none; color:#999;"><small>What technologies did you use?</small></span>
	</div>
</div>

<div class="form-group">
	{{ Form::label('material', 'Material:', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-5">
		{{ Form::text('material', null, array('class' => 'form-control input-sm')) }}
		@if($errors->first('material')) 
			<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
			@foreach ($errors->get('material') as $error)
				{{ $error }}
			@endforeach
			</p>
		@endif
		</div>
	<div class="col-sm-5">
	<span style="display:none; color:#999;"><small>List all materials you used.</small></span>
	</div>
</div>

<div class="form-group">
	{{ Form::label('costs', 'Costs:', array('class' => 'col-sm-2 control-label')) }}
	<div class="col-sm-5">
		{{ Form::text('costs', null, array('class' => 'form-control input-sm')) }}
		@if($errors->first('costs')) 
			<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
			@foreach ($errors->get('costs') as $error)
				{{ $error }}
			@endforeach
			</p>
		@endif
		</div>
	<div class="col-sm-5">
	<span style="display:none; color:#999;"><small>How much money did you spend on this very step?</small></span>
	</div>
</div>

<div class="form-group required">
	{{ Form::label('description', 'Description:', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-7">
		{{ Form::textarea('description', null, array('class' => 'form-control', 'rows' => '5', 'maxlength' => '1000'))}}
		@if($errors->first('description')) 
			<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
			@foreach ($errors->get('description') as $error)
				{{ $error }}
			@endforeach
			</p>
		@endif
	</div>
	<div class="col-sm-3">
		<span style="display:none; color:#999;"><small>Describe in detail and full sentences what exactly you did.</small></span>
        <br><br>
        <span class="infobox" style="display:none; color:#999;"></span>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-2">
		{{ Form::label('photos', 'Photos:', array('class' => 'control-label'))}}
		<br>
		<span style="color:#999;"><small>If possible, upload pictures of how the project looks like after this session.</small></span>
	</div>
	<div class="photo-wrapper col-sm-10">
		@if (isset($projectsession))
			   <?php
                $imgExists = false;
                if((isset($edit) || isset($relist)) && $imgExists = $projectsession->hasImage()){
                    $imgPath = $projectsession->getImagePath();
                }

                if(Session::has('preuploadedFile')){
                    $imgPath = '/' . ProjectSession::$temporaryImagePath . Session::get('preuploadedFile');
                    $imgExists = true;
                }

                // Bild mit PHP in den Thumbnail Bereich skalieren
                if($imgExists){
                    ob_start();
                    $myImg = new MyImage(public_path() . $imgPath);
                    $i = $myImg->thumbnailbox(100, 100);
                    $imgSrc = 'data:' . $myImg->dataType . ';base64,' . base64_encode(ob_get_clean());
                }
              ?>
			<?php
				$files = array();
				if ($projectsession->files != "") $files = explode(',', $projectsession->files);
			?>
			@foreach ($files as $file)
			
			<div class="pull-left image-container">
				<div class="fileupload">
					<div class="fileulpoad-new thumbnail">
						<img src="{{$file}}" />
						<br />
					</div>
					<input type="hidden" name="existing_file[]" value="{{$file}}" />
					<button type="button" onclick="remove_image(this);" class="btn btn-danger title="Remove photo""><i class="fa fa-trash-o"></i></button>
				</div>
			</div>
			@endforeach
		@else
			<div class="pull-left image-container">
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="fileupload-new thumbnail"><i class="fa fa-picture-o"></i></div>
					<div class="fileupload-preview fileupload-exists thumbnail"></div>
					<br />
					<span class="btn btn-file"><span class="fileupload-new"><i class="fa fa-upload"></i></span><span class="fileupload-exists">Change</span><input type="file" name="file[]" /></span>
					<button type="button" onclick="remove_image(this);" class="btn btn-danger" title="Remove photo"><i class="fa fa-trash-o"></i></button>
				</div>
			</div>
		@endif

		<div  title="Add more photo" class="pull-left" id="add-image-btn">
			<div class="thumbnail" onclick="add_image();">
				<i class="fa fa-plus"></i>
			</div>		
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-2">
	{{ Form::label('docs', 'Documents:', array('class' => 'control-label'))}}
	<br>
	<span style="color:#999;"><small>Upload documents that are NOT photos here.</small></span>
	</div>
	<div class="photo-wrapper col-sm-10">
		@if (isset($projectsession))
			<?php
				$docs = array();
				if ($projectsession->docs != "") $docs = explode(',', $projectsession->docs);
			?>
			@foreach ($docs as $doc)
				<div class="pull-left image-container">
					<div class="fileupload">
						<div class="fileupload-new thumbnail">
							<img src="{{$doc}}" />
							<br />
						</div>
						<input type="hidden" name="existing_file[]" value="{{$doc}}" />
						<button type="button" onclick="remove_image(this);" class="btn btn-danger title="Remove photo""><i class="fa fa-trash-o"></i></button>
					</div>
				</div>
			@endforeach
		@else
		       <?php
                $imgExists = false;
                if((isset($edit) || isset($relist)) && $imgExists = $projectsession->hasImage()){
                    $imgPath = $projectsession->getImagePath();
                }

                if(Session::has('preuploadedFile')){
                    $imgPath = '/' . ProjectSession::$temporaryImagePath . Session::get('preuploadedFile');
                    $imgExists = true;
                }

                // Bild mit PHP in den Thumbnail Bereich skalieren
                if($imgExists){
                    ob_start();
                    $myImg = new MyImage(public_path() . $imgPath);
                    $i = $myImg->thumbnailbox(100, 100);
                    $imgSrc = 'data:' . $myImg->dataType . ';base64,' . base64_encode(ob_get_clean());
                }
              ?>
			<div class="pull-left image-container">
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="fileupload-new thumbnail"><i class="fa fa-file-text-o"></i></div>
					<div class="fileupload-preview fileupload-exists thumbnail"></div>
					<br />
					<span class="btn btn-file"><span class="fileupload-new"><i class="fa fa-upload"></i></span><span class="fileupload-exists">Change</span><input type="file" name="doc[]" /></span>
					<button type="button" onclick="remove_image(this);" class="btn btn-danger" title="Remove photo"><i class="fa fa-trash-o"></i></button>

				</div>
			</div>
		@endif
		<div  title="Add more photo" class="pull-left" id="add-file-btn">
			<div class="thumbnail" onclick="add_file();">
				<i class="fa fa-plus"></i>
			</div>		
		</div>
	</div>
</div>

<div class="form-group createproject">
<div class="col-sm-offset-2 col-sm-10">
{{ Form::submit('Edit Workstep',  array('class' => 'btn btn-success'))}}
{{ Form::close() }}

{{ Form::open(array('action' => array('ProjectSessionController@destroy', $projectsession->id), 'method' => 'DELETE', 'id' => 'deleteForm'))}}
{{Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', array('type' => 'button', 'onclick' => 'delete_session()', 'class' => 'btn btn-danger'))}}
{{ Form::close() }} 
</div>
</div>





@stop