@extends('layouts.master')

@section('head')

{{HTML::style('/css/redactor.css')}}
{{HTML::style('/css/redactor.bootstrap.css')}}
{{HTML::script('/js/redactor.min.js')}}


{{HTML::style('/css/bootstrap-fileupload.min.css')}}
{{HTML::script('/js/bootstrap-fileupload.min.js')}}


<style type="text/css">
	
</style>

<script type="text/javascript">

$(document).ready(function(){

	
});


$(function(){
	$('#redactor_content').redactor({
		imageUpload: '/tutorials/imageupload',
		//fileUpload: '/tutorials/fileupload',
		//imageGetJson: '/tutorials/getjson',
		//linebreaks: true,
		paragraphy: false,
		toolbarFixed: false,
		toolbarFixedTopOffset: 75, 
		buttons: ['formatting', '|', 'bold', 'italic', 'underline', '|',
'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
'image', 'video', 'file', 'link', '|', 'html' ],
		wym: false,
		formattingTags: ['h2', 'h3', 'p' ],
		allowedTags: ['h2', 'h3', 'p', 'b', 'strong', 'i', 'u', 'ul', 'ol', 'li', 'dl', 'dt', 'dd', 'img', 'a', 'br'],

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


function delete_tutorial() {
	bootbox.confirm("<h3>Do you really want to delete this tutorial?</h3>", function(result) {
		if (result) {
			$("form").attr("action", "/tutorials/delete");
			$("form").submit();
		}
	}); 
}
</script>

@stop

@section('content')
{{Form::open()}}


{{ (isset($tutorial)) ? Form::hidden('_id', $tutorial->id) : '' }}

<div class=" container-wrapper row">
		<div class="span11">
			<div class="create_title">
		        <p>Create a new tutorial</p>
			</div>
			<h4>Title:</h4>
			<fieldset>
				{{Form::text('title', (isset($tutorial)) ? $tutorial->title : '' , array(
					'placeholder' => 'Title',
					'class' => 'span11',
				));}}
				{{ ($errors->first('title')) ? '<p class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				Please provide a title</p>': ''}}
			</fieldset>
			<h3>What can others learn from it?</h3>
			<fieldset id="description">
				{{Form::textarea('description', (isset($tutorial)) ? $tutorial->description : '' , array(
					'placeholder' => 'Description',
					'class' => 'span11',
					'style' => 'height: 50px; resize: none; ',
				));}}
				{{ ($errors->first('description')) ? '<p class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				Please provide a description</p>': ''}}
			</fieldset>
			<p>&nbsp;</p>

			<h3>What steps need to be made?</h3>
			<fieldset>
				<textarea id="redactor_content" placeholder="Please write down the tutorial here: " name="content" style="display: none;">
					
				</textarea>			
			</fieldset>			
			<p>&nbsp;</p>
			<div class="project_type">
              <ul>                
                <li class="project_selection" > 
                  <div class="project_category"> 
                  <p>Category </p>
                  <form role="form">
			        <label class="checkbox-inline">
			          <input type="checkbox" id="inlineCheckbox1" value="option1"> DIY
			        </label>
			        <label class="checkbox-inline">
			          <input type="checkbox" id="inlineCheckbox2" value="option2"> 3D Printing
			        </label>
			        <label class="checkbox-inline">
			          <input type="checkbox" id="inlineCheckbox3" value="option3"> Laser Cutting
			        </label>
			      </form>
                  </div>                 
                </li>             
                <li class="project_tag">
                  <div>            
                    <p>Tags</p>
                    <p class="help-block">Separate tags by ","</p>
                    <form role="form">
                        <textarea class="form-control" rows="3"></textarea>
                    </form>
                  </div>  
                </li>            
              </ul>
            </div> 
            <p>&nbsp;</p> 			
		</div>
		<hr>
		<div>
			<input type="submit" value="Save tutorial" class="btn btn-success" style="background-color: #34a26a;">		 	
		 	<input type="submit" value="Cancel" class="btn btn-warning">
		 	
	 	</div>
		
			@if (Sentry::Check() && Sentry::getUser()->hasAccess('is_admin'))
			{{(isset($tutorial)) ? '<button type="button" class="btn btn-danger" onclick="delete_tutorial();">Delete tutorial</button>' : '' }}
			@endif
</div>


	{{Form::close()}}



@stop