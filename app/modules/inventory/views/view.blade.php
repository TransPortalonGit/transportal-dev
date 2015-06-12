@extends('layouts.admin')

@section('head')

{{HTML::style('/css/admin-inventory-page.css')}}

@stop

@section('content')

<br />
<ol class="breadcrumb">
	<li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
	<li><a href="/admin/inventory">Inventory</a></li>
	@if($code[0] == 'I')
	  	<li><a href="/admin/inventory/list/items">List of Items</a></li>
	  	<li class="active">View Item</li>
    @elseif($code[0] == 'B')
		<li><a href="/admin/inventory/list/boxes">List of Boxes</a></li>
	  	<li class="active">View Box</li>
  	@elseif($code[0] == 'S')
  		<li><a href="/admin/inventory/list/surfaces">List of Surfaces</a></li>
  		<li class="active">View Surface</li>
  	@elseif($code[0] == 'C')
  		<li><a href="/admin/inventory/list/cabinets">List of Cabinets</a></li>
  		<li class="active">View Cabinet</li>
 	@elseif($code[0] == 'R')
 		<li><a href="/admin/inventory/list/rooms">List of Rooms</a></li>
 		<li class="active">View Room</li>
  	@elseif($code[0] == 'T')
  		<li class="active">View Transaction</li>
 	@endif
<hr>
</ol>

<div class="form-container">
	
	@if($code[0] == 'R')
		<form method="post" action="/admin/inventory/update/{{$code}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$code}}" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
					<label class="control-label" for="name">Name:</label>
					<div class="controls">
						<input type="text" class="form-control" name="name" id="name" value="{{ $room[0]->name }}">
						{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
				
			<br />

			<div class="form-group">
				<a href="/admin/inventory/list/rooms"><button type="button" class="btn btn-default">Back</button></a>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		
		</form><!-- end room -->


	@elseif($code[0] == 'C')
		<form method="post" action="/admin/inventory/update/{{$code}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$code}}" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('columns') ? 'error' : '' }}">
					<label class="control-label" for="columns">Columns:</label>
					<div class="controls">
						<input type="number" min="{{$cabinet[0]->columns}}" class="form-control" name="columns" id="columns" value="{{$cabinet[0]->columns}}" />
						{{ $errors->first('columns', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
				
			<div class="form-group">
				<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
					<label class="control-label" for="description">Description:</label>
					<div class="controls">
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description">{{$cabinet[0]->description}}</textarea>
						{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<br />

			<div class="form-group">
				<a href="/admin/inventory/list/cabinets"><button type="button" class="btn btn-default">Back</button></a>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		
		</form><!-- end cabinet -->


	@elseif($code[0] == 'S')
		<form method="post" action="/admin/inventory/update/{{$code}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$code}}" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('columns') ? 'error' : '' }}">
					<label class="control-label" for="columns">Level:</label>
					<div class="controls">
						<select class="form-control" name="level" id="level">
							@if($surface_matrix && !$surface[0]->row == 0)
								@for($i=0; $i<$container_cabinet[0]->columns; $i++)
									@for($j=1; $j<=$surface_matrix[$i]; $j++)
										<option value="{{$i}}{{$j}}" <?php if($surface[0]->column == $i && $surface[0]->row == $all_surfaces[$j]->row) echo 'selected' ?> >C{{$i}} R{{$j}}</option>
									@endfor
								@endfor
							@else
								<option value="{{$surface[0]->id}}">C{{$surface[0]->column}} R{{$surface[0]->row}}</option>
							@endif
						</select>
						{{ $errors->first('level', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
				
			<div class="form-group">
				<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
					<label class="control-label" for="description">Description:</label>
					<div class="controls">
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description">{{$surface[0]->description}}</textarea>
						{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<br />

			<div class="form-group">
				<a href="/admin/inventory/list/surfaces"><button type="button" class="btn btn-default">Back</button></a>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		
		</form><!-- end surface -->


		@elseif($code[0] == 'B')
		<form method="get" name="update_surfaces" id="update_surfaces" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				
			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$code}}" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('cabinet') ? 'error' : '' }}">
					<label class="control-label" for="cabinet">Cabinet:</label>
					<div class="controls">
						<select class="form-control" name="cabinet2" id="cabinet2">
							@if(!$selected_cabinet_code)
								@foreach($cabinets as $cabinet)
									<option value="{{$cabinet->code}}" <?php if($assigned_cabinet_code == $cabinet->code) echo 'selected' ?> >{{$cabinet->code}} (Room: {{$cabinet->parent_code}})</option>
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

		<form method="post" action="/admin/inventory/update/{{$code}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
		
			<div class="form-group">
				<div class="control-group {{ $errors->has('surface') ? 'error' : '' }}">
					<label class="control-label" for="surface">Surface:</label>
					<div class="controls">
						<select class="form-control" name="surface" id="surface">
							@if(!$selected_surface_code)	
								@foreach($surfaces as $surface)
									<option value="{{$surface->code}}" <?php if($assigned_surface_code == $surface->code) echo 'selected' ?> >{{$surface->code}}</option>
								@endforeach
							@else
								@foreach($surfaces as $surface)
									<option value="{{$surface->code}}" <?php if($selected_surface_code == $surface->code) echo 'selected' ?> >{{$surface->code}}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label" for="description">Description of selected cabinet:</label>
				<div class="controls">
					@if(!$selected_cabinet_code) 
						<textarea type="text" maxlength="72" class="form-control" name="description_cabinet" id="description_cabinet" readonly>{{$cabinets[0]->description}}</textarea>
					@else
						<textarea type="text" maxlength="72" class="form-control" name="description_cabinet" id="description_cabinet" readonly>{{$selected_cabinet[0]->description}}</textarea>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
					<label class="control-label" for="description">Description of box:</label>
					<div class="controls">
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description">{{$box[0]->description}}</textarea>
						{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<br />
				
			<div class="form-group">
				<a href="/admin/inventory/list/boxes"><button type="button" class="btn btn-default">Cancel</button></a>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		
		</form><!-- end box -->


	@elseif($code[0] == 'T')
		<form method="post" action="/admin/inventory/update/{{$code}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
			
			<div class="form-group">	
				<div class="control-group {{ $errors->has('user') ? 'error' : '' }}">
					<label class="control-label" for="user">User:</label>
					<div class="controls">
						<select class="form-control" name="user" id="user">
							<option value="{{$assigned_user->id}}">{{$assigned_user->username}} | {{$assigned_user->email}}</option>
							@foreach($users as $user)
								@if($assigned_user->id != $user->id)
									<option value="{{$user->id}}">{{$user->username}} | {{$user->email}}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('item') ? 'error' : '' }}">
					<label class="control-label" for="item">Item:</label>
					<div class="controls">
						<select class="form-control" name="item" id="item">
							<option value="{{$assigned_item->id}}">{{$assigned_item->name}}</option>
							@foreach($items as $item)
								@if($assigned_item->id != $item->id)
									<option value="{{$item->id}}">{{$item->name}}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
				
			<div class="form-group">
				<div class="control-group {{ $errors->has('quantity') ? 'error' : '' }}">
					<label class="control-label" for="columns">Quantity:</label>
					<div class="controls">
						<input type="number" min="1" class="form-control" name="quantity" id="quantity" value="{{$transaction->quantity}}" />
						{{ $errors->first('quantity', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('user') ? 'error' : '' }}">
					<label class="control-label" for="user">Due Date:</label>
					<div class="controls">
						<input type="date" class="form-control" name="due_date" value="{{$transaction->due_date}}">
					</div>
				</div>
			</div>

			<br />

			<div class="form-group">
				<a href="/admin/inventory"><button type="button" class="btn btn-default">Back</button></a>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		
		</form><!-- end transaction -->


	@elseif($code[0] == 'I')
		<form method="get" name="update_list" id="update_list" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				
				<div class="form-group">
					<div class="control-group {{ $errors->has('nest') ? 'error' : '' }}">
						<label class="control-label" for="nest">Nest:</label>
						<div class="controls">
							<select class="form-control" name="nest" id="nest">
								@if(!$selected_nest)
									@foreach($nests as $nest)
										<option value="{{$nest}}" <?php if($nest == $pre_selected_nest) echo 'selected' ?> >{{$nest}}</option>
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

		<form method="post" action="/admin/inventory/update/{{$code}}" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
		
			<div class="form-group">
				<div class="control-group {{ $errors->has('surface') ? 'error' : '' }}">
					<label class="control-label" for="compartment">Compartment:</label>
					<div class="controls">
						<select class="form-control" name="compartment" id="compartment">
							@if(!$selected_nest)
								@foreach($precompartments as $precompartment)
									<option value="{{$precompartment->code}}" <?php if($precompartment->code == $pre_selected_compartment) echo 'selected' ?> >{{$precompartment->code}}</option>
								@endforeach
							@else
								@foreach($compartments as $compartment)
									<option value="{{$compartment->code}}">{{$compartment->code}}</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('code') ? 'error' : '' }}">
					<label class="control-label" for="code">Code:</label>
					<div class="controls">
						<input type="text" class="form-control" name="code" id="disabledInput" value="{{$code}}" readonly>
					</div>
				</div>
			</div>

			<div class="form-group">	
				<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
					<label class="control-label" for="name">Name:</label>
					<div class="controls">
						<input type="text" class="form-control" name="name" id="name" value="{{$item[0]->name}}" />
						{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('quantity') ? 'error' : '' }}">
					<label class="control-label" for="quantity">Quantity:</label>
					<div class="controls">
						<input type="number" min="1" class="form-control" name="quantity" id="quantity" value="{{$item[0]->quantity}}" />
						{{ $errors->first('quantity', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="control-group {{ $errors->has('image') ? 'error' : '' }}">
					<label class="control-label" for="image">Image:</label>
					<div class="controls">
						<input type="file" class="form-control" name="image" id="image" value="{{$item[0]->image}}">
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="control-group {{ $errors->has('description') ? 'error' : '' }}">
					<label class="control-label" for="description">Description:</label>
					<div class="controls">
						<textarea type="text" maxlength="72" class="form-control" name="description" id="description">{{$item[0]->description}}</textarea>
						{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
			</div>

			<div class="form-group" id="desc-box-area-boxes">
			</div>

			<br />
				
			<div class="form-group">
				<a href="/admin/inventory"><button type="button" class="btn btn-default">Cancel</button></a>
				<button type="submit" class="btn btn-primary">Update</button>
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