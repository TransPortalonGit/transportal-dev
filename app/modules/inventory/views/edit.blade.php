@extends('layouts.admin')

@section('content')

<ol class="breadcrumb">
  <li><span class="fa fa-home"></span><a href="/admin"> Home</a></li>
  <li><a href="/admin/inventory">Inventory</a></li>
  <li class="active">Edit item</li>
<hr>
</ol>

	<form method="post" action="/admin/inventory/update" class="form-horizontal" autocomplete="off">

			
				<!-- CSRF Token -->
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="_id" value="{{ $item->id }}" />
		<div class="row">
			<div class="col-xs-3">
				
				<!-- Item Name -->
				<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
				<label class="control-label" for="username">Name</label>
					<div class="controls">
						<input type="text" name="name" id="name" value="{{ $item->name }}" />
						{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- Quantity -->
				<div class="control-group {{ $errors->has('quantity') ? 'error' : '' }}">
				<label class="control-label" for="quantity">Quantity</label>
					<div class="controls">
						<input type="number" name="quantity" id="quantity" value="{{ $item->quantity }}" />
						{{ $errors->first('quantity', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<!-- Category -->
				<div class="control-group {{ $errors->has('category') ? 'error' : '' }}">
				<label class="control-label" for="category">Category</label>
					<div>
					<select name="category" id="category">
					@if ($item->category == 1)
					<option value="1">lab only</option>
					<option value="2">loanable</option>
					@else
					<option value="2">loanable</option>
					<option value="1">lab only</option>
					@endif
					</select>
					</div>
				</div>
			</div>
		</div>
			<div class="control-group">
					<label class="control-label" for=""></label>
					<div class="controls">
						* required fields
						<p>
						</p>
					</div>
				</div>
			<!-- Form actions -->
				<div class="control-group">
					<div class="controls">
						<a href="/admin/inventory"><button type="button" class="btn btn-default"> Cancel</button></a>
						<button type="submit" onclick="{{ $item->id }}" class="btn btn-primary"> Apply</button>
					</div>
				</div>
			</form>


@stop