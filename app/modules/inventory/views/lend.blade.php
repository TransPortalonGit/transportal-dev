@extends('layouts.admin')

@section('head')

{{HTML::style('/css/jquery-ui.min.css')}}
{{HTML::style('/css/admin-inventory-page.css')}}
{{HTML::script('/js/jquery-ui.min.js')}}



@stop

@section('content')

<br />
<ol class="breadcrumb">
  <li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
  <li><a href="/admin/inventory">Inventory</a></li>
  <li><a href="/admin/inventory/list/items">List of Items</a></li>
  <li class="active">Lend</li>
<hr>
</ol>

<div class="form-container">

	<form method="post" action="/admin/inventory/lend" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" role="form">
		<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
		
		<div class="form-group">	
			<div class="control-group {{ $errors->has('item') ? 'error' : '' }}">
				<label class="control-label" for="item">Item:</label>
				<div class="controls">
					<input type="text" class="form-control" name="item_name" id="disabledInput" value="{{$item->name}}" readonly>
				</div>
			</div>
		</div>

		<div class="form-group">
				<div class="control-group {{ $errors->has('quantity') ? 'error' : '' }}">
					<label class="control-label" for="columns">Quantity:</label>
					<div class="controls">
						<input type="number" min="1" max="{{$item->quantity}}" class="form-control" name="quantity" id="quantity" value="{{$item->quantity}}" />
						{{ $errors->first('quantity', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
		</div>

		<div class="form-group">	
			<div class="control-group {{ $errors->has('user') ? 'error' : '' }}">
				<label class="control-label" for="user">User (username):</label>
				<div class="controls">
					<input type="text" class="form-control input-sm" name="auto" id="auto" />
				</div>
			</div>
		</div>

		<div class="form-group">	
			<div class="control-group {{ $errors->has('due_date') ? 'error' : '' }}">
				<label class="control-label" for="due_date">Due Date:</label>
				<div class="controls">
					<input type="date" class="form-control" name="due_date">
					{{ $errors->first('due_date', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div>
			
		<br />

		<div class="form-group">
			<a href="/admin/inventory/list/items"><button type="button" class="btn btn-default">Cancel</button></a>
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	
	</form>

<script type="text/javascript">

	$('#auto').autocomplete({
		source: '/search/grabdata',
		minLength:1,
		select:function(e, ui){
			console.log(ui);
		}
	});

</script>

@stop