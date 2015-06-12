@extends('layouts.master')

@section('head')

{{HTML::style('/css/project.css')}}

{{HTML::style('/css/redactor.css')}}
{{HTML::style('/css/redactor.bootstrap.css')}}
{{HTML::script('/js/redactor.min.js')}}
{{HTML::script('/js/projects--create.js')}}					<!-- HIER -->

{{HTML::style('/css/bootstrap-fileupload.min.css')}}
{{HTML::script('/js/bootstrap-fileupload.min.js')}}
{{HTML::style('/css/magicsuggest-min.css')}}
{{HTML::script('/js/magicsuggest-min.js')}}


<script type="text/javascript">

$(document).ready(function(){

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

	$("select").change(function() {
		$(this).parent().siblings("div").children("span").fadeToggle();
	})
	
});

$(function() {

    $('#member_selection').magicSuggest({
    	data: 'userslist',
    	valueField: 'id',
    	displayField: 'username'
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

function delete_project() {
	bootbox.confirm("<h3>Do you really want to delete this project?</h3>", function(result) {
		if (result) {
			$("form").attr("action", "/projects/delete");
			$("form").submit();
		}
	}); 
}

</script>
        
@stop

@section('content')
@include('site/listings/partials/_form-header', ['title' => 'Create a new Project'])
{{Form::open(array('enctype' => "multipart/form-data", 'action' => 'ProjectController@store', 'class' => 'form-horizontal'))}}

{{ (isset($project)) ? Form::hidden('_id', $project->id) : '' }}
	
<div class="form-group required">
	{{ Form::label('title', 'Title:', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-5">
		{{ Form::text('title', null, array('class' => 'form-control input-sm', 'placeholder' => 'Title')) }}
		@if($errors->first('title')) 
		<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
		@foreach ($errors->get('title') as $error)
			{{ $error }}
		@endforeach
		</p>
	@endif
	</div>
	<div class="col-sm-5">
		<span style="display:none; color:#999;"><small>Provide a title for your project (at least 5 characters).</small></span>
	</div>
</div>


<div class="form-group">
	{{ Form::label('type', 'Type:', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-5">
		{{Form::select('type', array('individual' => 'Individual Project', 'group' => 'Group Project'), '', array('class' => 'form-control'))}}
		@if($errors->first('type')) 
		<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
		@foreach ($errors->get('type') as $error)
			{{ $error }}
		@endforeach
		</p>
	@endif
	</div>
	<div class="col-sm-5">
		<span style="display:none; color:#999;">{{ Form::text('members', null, array('class' => 'form-control input-sm', 'placeholder' => 'Enter group members', 'id' => 'member_selection')) }}
		<span id="filter-count"></span>
</span>
	</div>
</div>

<div class="form-group required">
	{{ Form::label('content', 'Description:', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-7">
		{{ Form::textarea('content', null, array('class' => 'form-control', 'rows' => '5', 'maxlength' => '500'))}}

		<!--<textarea id="redactor_content" name="content" type="text" style="display: none; overflow: scroll;">
			@if(Input::old('content'))
			{{Input::old('content')}}
			@endif
		</textarea>-->
		@if($errors->first('content')) 
			<p class="alert alert-danger alert-dismissable" style="margin-top: 10px;">
			@foreach ($errors->get('content') as $error)
				{{ $error }}
			@endforeach
			</p>
		@endif	
	</div>

	<div class="col-sm-3">
		<span style="display:none; color:#999;"><small>What are you going to create? Give a short description of the project.</small></span>
        <br><br>
        <span class="infobox" style="display:none; color:#999;"></span>
	</div>
</div>	

<div class="form-group required">
	{{ Form::label('content', 'Img Thumbnail:', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-7">
		
		{{ Form::file('image', array('class' => 'form-control', 'name' => 'imgInput')) }}

	</div>
</div>


			@if (Sentry::Check() && Sentry::getUser()->hasAccess('is_admin'))
			{{(isset($project)) ? '<button type="button" class="btn btn-danger" onclick="delete_project();">Delete project</button>' : '' }}
			@endif

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
	{{ Form::submit('Create project',  array('class' => 'btn btn-success'))}}
	<input  data-toggle="modal" data-target=".cancel-project" type="button" value="Cancel" class="btn btn-warning" >
</div>
</div>

		<hr>

		<div class="row">
		<div class="col-md-7">

		<p> <strong>Guidelines:</strong></br>
TransPortal is a place for you to share creative FabLab designs.</br>
1. Designsst represent a real, physical object that can be made.</br>
2. Please only upload designs you've created or participated closely in creating.</br>
3. You may upload open-source/copyleft designs if you provide attribution.</br>
4. No pornographic or sexually explicit designs.</br>
5. Please don't upload weapons. The world has plenty of weapons already. </br> (reference: Thingiverse. March,2014)</p>
</div>
<!--<div class="col-md-5"><strong>Supported Filetypes:</strong> </br>
We allow uploading of almost any filetype. If you can digitally represent a physical object, then please upload your files to Thingiverse. 

stl, dxf, svg, ai, cdr, jpg, gif, png, pdf, tiff, eps, ps, sch, brd, pov
</div> --></div>


	 	<div> 	

		 	
			<!-- Small modal -->
			<div class="modal fade cancel-project" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
			    <div class="modal-content">
			      	<div class="modal-header">
			          	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			          	<h4 class="modal-title" id="mySmallModalLabel">Are you sure you want to cancel?</h4>
			      	</div>
			      	<div class="modal-body">
			      		<p>All progress will be lost.</p>
			      	</div>

			      	<div class="modal-footer">
				        <button type="button" class="btn btn-success" data-dismiss="modal">Keep editing</button>
				        <button action="action" type="button" onclick="javascript:window.location.href='/home'"  class="btn btn-warning">Cancel project</button>
				    </div>
			    </div>
			  </div>
			</div>
	 	</div>
	</div>



	{{Form::close()}}



@stop