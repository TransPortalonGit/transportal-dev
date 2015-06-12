@extends('layouts.master')

@section('page_header')
	<i class="icon-book"></i> <a href="/tutorials">Tutorials</a> <i class="icon-angle-right"></i> Create new tutorial
@stop

@section('head')
{{HTML::script('/js/bootstrap-wysiwyg.js')}}
{{HTML::script('/js/jquery.hotkeys.js')}}


<style type="text/css">
		
	#editor {
		max-height: 250px;
		height: 250px;
		background-color: white;
		border-collapse: separate; 
		border: 1px solid rgb(204, 204, 204); 
		padding: 4px; 
		box-sizing: content-box; 
		-webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset; 
		box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
		border-top-right-radius: 3px; border-bottom-right-radius: 3px;
		border-bottom-left-radius: 3px; border-top-left-radius: 3px;
		overflow: scroll;
		outline: none;
	}

	#voiceBtn {
		width: 20px;
		color: transparent;
		background-color: transparent;
		transform: scale(2.0, 2.0);
		-webkit-transform: scale(2.0, 2.0);
		-moz-transform: scale(2.0, 2.0);
		border: transparent;
		cursor: pointer;
		box-shadow: none;
		-webkit-box-shadow: none;
	}

	div[data-role="editor-toolbar"] {
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	
	.dropdown-menu a {
		cursor: pointer;
	}
	
	
	#editor hr {
		padding: 0;
		border: none;
		border-top: medium double #ccc;
		color: #333;
		text-align: center;
		margin-bottom: -5px;
	}
	
	#editor hr:after {
		content: "New Step";
		display: inline-block;
		position: relative; 
		top: -12px;  
		font-size: 12px;
		line-height: 12px;
		padding: 0 12px;
		background: white;
		color: #bbb;
	}

</style>

<script type="text/javascript">
function viewsource(source) {
	var html;
	if (source) {
		html = $('#editor').html();
		$('#htmlcode').val(html);
		$('#htmlcode').show();
		$('#editor').hide();
		$('#toolbar').hide();
	} else {
		html = $('#htmlcode').val();
		$('#editor').html(html);
		$('#htmlcode').hide();
		$('#toolbar').show();
		$('#editor').show();
	}
}



function initToolbarBootstrapBindings() {
	$('a[title]').tooltip({container:'body'});

	$('.dropdown-menu input').click(function() {return false;})
	    .change(function () {$(this)
	    .parent('.dropdown-menu')
	    .siblings('.dropdown-toggle')
	    .dropdown('toggle');})
		.keydown('esc', function () {
			this.value='';$(this).change();
		});
	
	$('[data-role=magic-overlay]').each(function () { 
		var overlay = $(this), target = $(overlay.data('target')); 
		overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
	});

	if ("onwebkitspeechchange"  in document.createElement("input")) {
		var editorOffset = $('#editor').offset();
		$('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
	} else {
		$('#voiceBtn').hide();
	}
};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    

$(document).ready(function(){
	
    initToolbarBootstrapBindings();  
	
	$('#editor').wysiwyg({
		fileUploadError: showErrorAlert,
		hotKeys: {
		    'ctrl+b meta+b': 'bold',
		    'ctrl+i meta+i': 'italic',
		    'ctrl+u meta+u': 'underline',
		    'ctrl+z meta+z': 'undo',
		    'ctrl+y meta+y meta+shift+z': 'redo'
		},
  		activeToolbarClass: 'btn-primary',
		
	} );
	
	
	
	$("form").submit(function() {
		var html = $('#editor').html();
		$("#htmlcode").val(html);
	});
	
	
});


</script>



@stop

@section('content')
{{Form::open()}}


{{ (isset($tutorial)) ? Form::hidden('_id', $tutorial->id) : '' }}


<div class="well">
	<div class="row">
		<div class="span11">
			
			{{Form::text('title', (isset($tutorial)) ? $tutorial->title : '' , array(
				'placeholder' => 'Title',
				'class' => 'span11',
			));}}

			{{Form::textarea('description', (isset($tutorial)) ? $tutorial->description : '' , array(
				'placeholder' => 'Description',
				'class' => 'span11',
				'style' => 'height: 50px;',
			));}}
			
			<div id="toolbar" class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
				<div class="btn-group">
					<a class="btn" data-edit="inserthtml <hr><h2>Step title</h2>" title="New Step"><i class="icon-plus"></i> Add Step</a>
				</div>
				
				<div class="btn-group">
					<a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a data-edit="formatblock h3"><h3>Heading</h3></a></li>
						<li><a data-edit="formatblock p"><p>Paragraph</p></a></li>
					</ul>
				</div>
				<div class="btn-group">
					<a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
					<a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
					<a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
				</div>
				<div class="btn-group">
					<a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
					<a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
					<a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
					<a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
				</div>
				
				<div class="btn-group">
					<a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
					<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
				</div>
				<div class="btn-group">
					<a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
					<a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
				</div>
				<input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
			</div>
				
			<div id="editor">{{(isset($tutorial)) ? $tutorial->content : '<hr><h2>Step title</h2>' }}</div>
			<input type="checkbox" onclick="viewsource(this.checked)"> Source
			
			<textarea style="display: none" id="htmlcode" name="htmlcode"></textarea>
<p>&nbsp;</p>
			<input type="submit" value="Save tutorial" class="btn btn-primary">

		</div>
	</div>

</div>
	{{Form::close()}}



@stop