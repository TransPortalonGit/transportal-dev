@extends('layouts.admin')

@section('content')
<ol class="breadcrumb">
  <li><span class="fa fa-home"></span><a href="/admin"> Home</a></li>
  <li><a href="/admin/inventory">Inventory</a></li>
  <li class="active">Add item</li>
<hr>
</ol>

			<form method="post" action="/admin/inventory/create" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">

					
						<!-- CSRF Token -->
						<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
				<div class="row">
					<div class="col-xs-3">
						
						<!-- Item name -->
						<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
						<label class="control-label" for="name">Name*</label>
							<div class="controls">
								<input type="text" name="name" id="name" value="{{ Input::old('name') }}" />
								{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Quantity -->
						<div class="control-group {{ $errors->has('quantity') ? 'error' : '' }}">
						<label class="control-label" for="quantity">Quantity*</label>
							<div class="controls">
								<input type="number" name="quantity" id="quantity" value="{{ Input::old('quantity') }}" />
								{{ $errors->first('quantity', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Category -->
						<div class="control-group {{ $errors->has('category') ? 'error' : '' }}">
						<label class="control-label" for="category">Category</label>
							<div>
							<select name="category" id="category">
							<option value="2">loanable</option>
							<option value="1">lab only</option>
							</select>
							</div>
						</div>

						<!-- Status -->
						<div class="control-group {{ $errors->has('status') ? 'error' : '' }}">
						<label class="control-label" for="status">Status</label>
							<div>
							<select name="status" id="status">
							<option value="1">active</option>
							<option value="0">loaned</option>
							</select>
							</div>
						</div>

						<!-- Descriptive Image -->
						<div class="control-group {{ $errors->has('image') ? 'error' : '' }}">
							<label class="control-label" for="image_upload">Image</label>
							<input type="file" name="image" id="image"><br>
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
								<button type="submit" class="btn btn-primary"> Add</button>
							</div>
						</div>
					</form>


@stop