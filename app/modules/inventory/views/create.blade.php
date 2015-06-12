@extends('layouts.admin')

@section('head')

{{HTML::style('/css/admin-inventory-page.css')}}

<script type="text/javascript">

function add_desc_surfaces(rows) 
{
	$('#desc-box-area-surfaces').empty();

	for(var i = 1; i <= rows; i++)
	{
		var output = "";
		output += '<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">';
		output += '<label class="control-label" for="description">Description[' + i + ']:</label>';
		output += '<div class="controls">';
		output += '<textarea type="text" maxlength="72" class="form-control" name="description' + i + '" id="description' + i + '"></textarea>';
		output += '{{ $errors->first('description', '<span class="help-inline">:message</span>') }}'
		output += '</div>';
		output += '</div>';
		$('#desc-box-area-surfaces').append(output);
	}

}

function add_desc_boxes(boxes) 
{
	$('#desc-box-area-boxes').empty();

	for(var i = 1; i <= boxes; i++)
	{
		var output = "";
		output += '<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">';
		output += '<label class="control-label" for="description">Description[' + i + ']:</label>';
		output += '<div class="controls">';
		output += '<textarea type="text" maxlength="72" class="form-control" name="description' + i + '" id="description' + i + '"></textarea>';
		output += '{{ $errors->first('description', '<span class="help-inline">:message</span>') }}'
		output += '</div>';
		output += '</div>';
		$('#desc-box-area-boxes').append(output);
	}

}

</script>

@stop

@section('content')

<br />
<ol class="breadcrumb">
  <li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
  <li><a href="/admin/inventory">Inventory</a></li>
  @if($type == "item")<li class="active">Create Item</li>
  @elseif($type == "box")<li class="active">Create Box</li>
  @elseif($type == "surface")<li class="active">Create Surface</li>
  @elseif($type == "cabinet")<li class="active">Create Cabinet</li>
  @elseif($type == "room")<li class="active">Create Room</li>
  @endif
<hr>
</ol>

<div class="form-container">
	
	@if($type == "room")
		<form method="post" action="/admin/inventory/create/room" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$generated_code}}" readonly>
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
					<label class="control-label" for="name">Name:</label>
					<div class="controls">
						<input type="text" class="form-control" name="name" id="name" value="{{ Input::old('name') }}" />
						{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
				
			<br />

			<div class="form-group">
				<a href="/admin/inventory"><button type="button" class="btn btn-default">Cancel</button></a>
				<button type="submit" class="btn btn-primary">Submit</button>
				<button name="next" value="next" type="submit" class="btn btn-success">Next</button>
			</div>
		
		</form><!-- end room -->

	@elseif($type == "cabinet")
		<form method="post" action="/admin/inventory/create/cabinet" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$generated_code}}" readonly>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('room') ? 'error' : '' }}">
					<label class="control-label" for="room">Room:</label>
					<div class="controls">
						<select class="form-control" name="room" id="room">
							@foreach($rooms as $room)
								<option value="{{$room->code}}"  <?php if(\Session::get('code') == $room->code) echo 'selected' ?> >{{$room->code}} | {{$room->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('columns') ? 'error' : '' }}">
					<label class="control-label" for="columns">Columns:</label>
					<div class="controls">
						<input type="number" min="1" placeholder="1" class="form-control" name="columns" id="columns" value="1" />
						{{ $errors->first('columns', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
					<label class="control-label" for="description">Description:</label>
					<div class="controls">
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description"></textarea>
						{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<br />
				
			<div class="form-group">
				<a href="/admin/inventory"><button type="button" class="btn btn-default">Cancel</button></a>
				<button type="submit" class="btn btn-primary">Submit</button>
				<button name="next" value="next" type="submit" class="btn btn-success">Next</button>
			</div>
		
		</form><!-- end cabinet -->

	@elseif($type == "surface")
		<form method="get" name="update_columns" id="update_columns" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				
				<div class="form-group">
					<div class="control-group {{ $errors->has('cabinet') ? 'error' : '' }}">
						<label class="control-label" for="cabinet">Cabinet:</label>
						<div class="controls">
							<select class="form-control" name="cabinet" id="cabinet">
								@if(!$selected_cabinet_code)
									@foreach($cabinets as $cabinet)
										<option value="{{$cabinet->code}}" <?php if(\Session::get('code') == $cabinet->code) echo 'selected' ?> >{{$cabinet->code}} (Room: {{$cabinet->parent_code}})</option>
									@endforeach
								@else
									<option value="{{$selected_cabinet[0]->code}}">{{$selected_cabinet[0]->code}} (Room: {{$selected_cabinet[0]->parent_code}})</option>
									@foreach($cabinets as $cabinet)
										@if($cabinet->code != $selected_cabinet[0]->code)
											<option value="{{$cabinet->code}}">{{$cabinet->code}} (Room: {{$cabinet->parent_code}})</option>
										@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>

		</form>

		<form method="post" action="/admin/inventory/create/surface" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			@if(!$selected_cabinet_code)
				<input type="hidden" name="cabinet" id="cabinet" value="{{$cabinets[0]->code}}">
			@else
				<input type="hidden" name="cabinet" id="cabinet" value="{{$selected_cabinet[0]->code}}">
			@endif

			<div class="form-group">
				<label class="control-label" for="description">Description of selected cabinet:</label>
				<div class="controls">
					@if(!$selected_cabinet_code && Session::get('code') != null)
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description" readonly>{{$cabinet->description}}</textarea>
					@elseif(!$selected_cabinet_code && Session::get('code') == null) 
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description" readonly>{{$cabinets[0]->description}}</textarea>
					@else
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description" readonly>{{$selected_cabinet[0]->description}}</textarea>
					@endif
				</div>
			</div>	

			<div class="form-group">
				<div class="control-group {{ $errors->has('column') ? 'error' : '' }}">
					<label class="control-label" for="column">Column:</label>
					<div class="controls">
						<select class="form-control" name="column" id="column">
							@if(!$selected_cabinet_code)
								@if($cabinets[0]->columns == '0')
									<option value="0">0</option>
								@else
									@for($i=0; $i<=$cabinets[0]->columns-1; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								@endif
							@else
								@if($selected_cabinet[0]->columns == '0')
									<option value="0">0</option>
								@else
									@for($i=0; $i<=$selected_cabinet[0]->columns-1; $i++)
										<option value="{{$i}}">{{$i}}</option>
									@endfor
								@endif
							@endif
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('rows') ? 'error' : '' }}">
					<label class="control-label" for="rows">Rows:</label>
					<div class="controls">
						<input type="number" min="1" class="form-control" name="rows" id="rows" value="{{ Input::old('rows') }}" />
						{{ $errors->first('rows', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group" id="desc-box-area-surfaces">
			</div>

			<br />
				
			<div class="form-group">
				<a href="/admin/inventory"><button type="button" class="btn btn-default">Cancel</button></a>
				<button type="submit" class="btn btn-primary">Submit</button>
				<button name="next" value="next" type="submit" class="btn btn-success">Next</button>
			</div>
		
		</form><!-- end surface -->

	@elseif($type == "box")
		<form method="get" name="update_surfaces" id="update_surfaces" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				
				<div class="form-group">
					<div class="control-group {{ $errors->has('cabinet') ? 'error' : '' }}">
						<label class="control-label" for="cabinet">Cabinet:</label>
						<div class="controls">
							<select class="form-control" name="cabinet2" id="cabinet2">
								@if(!$selected_cabinet_code)
									@foreach($cabinets as $cabinet)
										<option value="{{$cabinet->code}}" <?php if(\Session::get('code') == $cabinet->code) echo 'selected' ?> >{{$cabinet->code}} (Room: {{$cabinet->parent_code}})</option>
									@endforeach
								@else
									<option value="{{$selected_cabinet[0]->code}}">{{$selected_cabinet[0]->code}} (Room: {{$selected_cabinet[0]->parent_code}})</option>
									@foreach($cabinets as $cabinet)
										@if($cabinet->code != $selected_cabinet[0]->code)
											<option value="{{$cabinet->code}}">{{$cabinet->code}} (Room: {{$cabinet->parent_code}})</option>
										@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>
	
		</form>

		<form method="post" action="/admin/inventory/create/box" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			<div class="form-group">
				<label class="control-label" for="description">Description of selected cabinet:</label>
				<div class="controls">
					@if(!$selected_cabinet_code && Session::get('code') != null)
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description" readonly>{{$cabinet->description}}</textarea>
					@elseif(!$selected_cabinet_code && Session::get('code') == null) 
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description" readonly>{{$cabinets[0]->description}}</textarea>
					@else
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description" readonly>{{$selected_cabinet[0]->description}}</textarea>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('surface') ? 'error' : '' }}">
					<label class="control-label" for="surface">Surface:</label>
					<div class="controls">
						<select class="form-control" name="surface" id="surface">
								@foreach($surfaces as $surface)
									<option value="{{$surface->code}}">{{$surface->code}}</option>
								@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('boxes') ? 'error' : '' }}">
					<label class="control-label" for="boxes">Boxes:</label>
					<div class="controls">
						<input type="number" min="1" class="form-control" name="boxes" id="boxes" value="{{ Input::old('boxes') }}" />
						{{ $errors->first('boxes', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group" id="desc-box-area-boxes">
			</div>

			<br />
				
			<div class="form-group">
				<a href="/admin/inventory"><button type="button" class="btn btn-default">Cancel</button></a>
				<button type="submit" class="btn btn-primary">Submit</button>
				<button name="next" value="next" type="submit" class="btn btn-success">Next</button>
			</div>
		
		</form><!-- end box -->

	@elseif($type == "item")
		<form method="get" name="update_list" id="update_list" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				
				<div class="form-group">
					<div class="control-group {{ $errors->has('nest') ? 'error' : '' }}">
						<label class="control-label" for="nest">Nest:</label>
						<div class="controls">
							<select class="form-control" name="nest" id="nest">
								@if(!$selected_nest)
									@foreach($nests as $nest)
										<option value="{{$nest}}">{{$nest}}</option>
									@endforeach
								@else
									<option value="{{$selected_nest}}">{{$selected_nest}}</option>
									@foreach($nests as $nest)
										@if($nest != $selected_nest)
											<option value="{{$nest}}">{{$nest}}</option>
										@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>
	
		</form>

		<form method="post" action="/admin/inventory/create/item" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
		
			<div class="form-group">
				<div class="control-group {{ $errors->has('surface') ? 'error' : '' }}">
					<label class="control-label" for="compartment">Compartment:</label>
					<div class="controls">
						<select class="form-control" name="compartment" id="compartment">
								@foreach($compartments as $compartment)
									<option value="{{$compartment->code}}">{{$compartment->code}}</option>
								@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$generated_code}}" readonly>
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
					<label class="control-label" for="name">Name:</label>
					<div class="controls">
						<input type="text" class="form-control" name="name" id="name" value="{{ Input::old('name') }}" />
						{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('quantity') ? 'error' : '' }}">
					<label class="control-label" for="quantity">Quantity:</label>
					<div class="controls">
						<input type="number" min="1" class="form-control" name="quantity" id="quantity" value="{{ Input::old('quantity') }}" />
						{{ $errors->first('quantity', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="control-group {{ $errors->has('image') ? 'error' : '' }}">
					<label class="control-label" for="image">Image:</label>
					<div class="controls">
						<input type="file" class="form-control" name="image" id="image">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
					<label class="control-label" for="description">Description:</label>
					<div class="controls">
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description"></textarea>
						{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group" id="desc-box-area-boxes">
			</div>

			<br />
				
			<div class="form-group">
				<a href="/admin/inventory"><button type="button" class="btn btn-default">Cancel</button></a>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		
		</form><!-- end item -->

	@endif
</div>


<script type="text/javascript">

$("#rows").change(function() 
{
	var rows = $(this).val();
	add_desc_surfaces(rows);

});

$("#boxes").change(function() 
{
	var boxes = $(this).val();
	add_desc_boxes(boxes);

});

$("#cabinet").change(function() 
{
	var selected_cabinet = $(this).val();
	$('#update_columns').trigger('submit');
	
});

$("#cabinet2").change(function() 
{
	var selected_cabinet = $(this).val();
	$('#update_surfaces').trigger('submit');
	
});

$("#nest").change(function() 
{
	var selected_cabinet = $(this).val();
	$('#update_list').trigger('submit');
	
});

</script>

@stop