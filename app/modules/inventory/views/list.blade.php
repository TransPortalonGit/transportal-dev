@extends('layouts.admin')

@section('head')

<script type="text/javascript">

function delete_this(code) 
{
    bootbox.confirm("Are you sure you want to delete " + code + "?", function(result) {

        if(result==true) 
        {
           window.location = "/admin/inventory/delete/" + code
        }

    });
}

function report_broken(code) 
{
    bootbox.prompt("How many articles of " + code + " are broken?", function(qty) {

        if(qty==null) 
        {

        }
        else
        {
        	window.location = "/admin/inventory/report/" + code + "/" + qty
        }

    });
}

</script>

@stop

@section('content')

<br />
<ol class="breadcrumb">
  <li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
  <li><a href="/admin/inventory">Inventory</a></li>
  @if($type == "items")<li class="active">List of Items</li>
  @elseif($type == "boxes")<li class="active">List of Boxes</li>
  @elseif($type == "surfaces")<li class="active">List of Surfaces</li>
  @elseif($type == "cabinets")<li class="active">List of Cabinets</li>
  @elseif($type == "rooms")<li class="active">List of Rooms</li>
  @endif
<hr>
</ol>

<div class="form-container">
	@if( Session::has('success') )
		<div class="alert alert-success" role="alert">  {{Session::get('success')}} </div>
	@elseif( Session::has('error') )
		<div class="alert alert-danger" role="alert">  {{Session::get('error')}} </div>
	@endif
	@if($type == 'rooms')
		<div class="panel panel-default">
			<div class="panel-heading"><span class="glyphicon glyphicon-list"></span> <font style="color:#2686ff">Rooms'</font> List</div>
			<table class="table table-striped table-bordered table-hover">
			   
			    <thead>
			        <tr>
			            <th>Id</th>
			            <th>CODE</th>
			            <th>NAME</th>
			            <th>SELECT</th>
			        </tr>
			    </thead>
			   
			    <tbody>
			   
			    @foreach($rooms as $room)
			        <tr>
			            <td>
			                {{ $room->id }}
			            </td>
			            <td>
			                {{ $room->code }}
			            </td>
			            <td>
			                {{ $room->name }}
			            </td>
			            <td class="col-xs-2">
			                <a href="/admin/inventory/view/{{$room->code}}"><button type="button" class="btn btn-xs btn-info" title="view"><span class="glyphicon glyphicon-eye-open"></span></button></a>
			                <a href="/admin/inventory/csvlink/room/{{$room->code}}"><button type="button" class="btn btn-xs btn-primary" title="print"><span class="glyphicon glyphicon-print"></span></button></a>
			                <button onclick="delete_this('{{$room->code}}');" type="button" class="btn btn-xs btn-danger" title="delete"><span class="glyphicon glyphicon-trash"></span></button>
			            </td>
			        </tr>
			    @endforeach     
			    
			    </tbody>

			</table>
		</div>

		<table align="right">
		    <tr>
		        <td>
					{{ $rooms->links() }}
		        </td>
		    </tr>
		</table>

		@endif<!-- End of Rooms -->

		@if($type == 'cabinets')
			<div class="panel panel-default">
				<div class="panel-heading"><span class="glyphicon glyphicon-list"></span> <font style="color:#2686ff">Cabinets'</font> List</div>
				<table class="table table-striped table-bordered table-hover">
				   
				    <thead>
				        <tr>
				            <th>Id</th>
				            <th>CODE</th>
				            <th>DESCRIPTION</th>
				            <th>COLUMNS</th>
				            <th>SELECT</th>
				        </tr>
				    </thead>
				   
				    <tbody>
				   
				    @foreach($cabinets as $cabinet)
				        <tr>
				            <td>
				                {{ $cabinet->id }}
				            </td>
				            <td>
				                {{ $cabinet->code }}
				            </td>
				            <td>
				                {{ $cabinet->description }}
				            </td>
				            <td>
				                {{ $cabinet->columns }}
				            </td>
				            <td class="col-xs-2">
			                	<a href="/admin/inventory/view/{{$cabinet->code}}"><button type="button" class="btn btn-xs btn-info" title="view"><span class="glyphicon glyphicon-eye-open"></span></button></a>
			                	<a href="/admin/inventory/csvlink/cabinet/{{$cabinet->code}}"><button type="button" class="btn btn-xs btn-primary" title="print"><span class="glyphicon glyphicon-print"></span></button></a>
			                	<button onclick="delete_this('{{$cabinet->code}}');" type="button" class="btn btn-xs btn-danger" title="delete"><span class="glyphicon glyphicon-trash"></span></button>
				            </td>
				        </tr>
				    @endforeach     
				    
				    </tbody>

				</table>
			</div>

			<table align="right">
			    <tr>
			        <td>
						{{ $cabinets->links() }}
			        </td>
			    </tr>
			</table>

		@endif<!-- End of Cabinets -->

		@if($type == 'surfaces')
			<div class="panel panel-default">
				<div class="panel-heading"><span class="glyphicon glyphicon-list"></span> <font style="color:#2686ff">Surfaces'</font> List</div>
				<table class="table table-striped table-bordered table-hover">
				   
				    <thead>
				        <tr>
				            <th>Id</th>
				            <th>CODE</th>
				            <th>LEVEL</th>
				            <th>DESCRIPTION</th>
				            <th>SELECT</th>
				        </tr>
				    </thead>
				   
				    <tbody>
				   
				    @foreach($surfaces as $surface)
				        <tr>
				            <td>
				                {{ $surface->id }}
				            </td>
				            <td>
				                {{ $surface->code }}
				            </td>
				            <td>
				                C{{ $surface->column }} R{{ $surface->row }}
				            </td>
				            <td>
				                {{ $surface->description }}
				            </td>
				            <td class="col-xs-2">
				                <a href="/admin/inventory/view/{{$surface->code}}"><button type="button" class="btn btn-xs btn-info" title="view"><span class="glyphicon glyphicon-eye-open"></span></button></a>
				                <a href="/admin/inventory/csvlink/surface/{{$surface->code}}"><button type="button" class="btn btn-xs btn-primary" title="print"><span class="glyphicon glyphicon-print"></span></button></a>
			                	<button onclick="delete_this('{{$surface->code}}');" type="button" class="btn btn-xs btn-danger" title="delete"><span class="glyphicon glyphicon-trash"></span></button>
				            </td>
				        </tr>
				    @endforeach     
				    
				    </tbody>

				</table>
			</div>

			<table align="right">
			    <tr>
			        <td>
						{{ $surfaces->links() }}
			        </td>
			    </tr>
			</table>

		@endif<!-- End of Surfaces -->

		@if($type == 'boxes')
			<div class="panel panel-default">
				<div class="panel-heading"><span class="glyphicon glyphicon-list"></span> <font style="color:#2686ff">Boxes'</font> List</div>
				<table class="table table-striped table-bordered table-hover">
			   
				    <thead>
				        <tr>
				            <th>Id</th>
				            <th>CODE</th>
				            <th>DESCRIPTION</th>
				            <th>SELECT</th>
				        </tr>
				    </thead>
				   
				    <tbody>
				   
				    @foreach($boxes as $box)
				        <tr>
				            <td>
				                {{ $box->id }}
				            </td>
				            <td>
				                {{ $box->code }}
				            </td>
				            <td>
				                {{ $box->description }}
				            </td>
				            <td class="col-xs-2">
				                <a href="/admin/inventory/view/{{$box->code}}"><button type="button" class="btn btn-xs btn-info" title="view"><span class="glyphicon glyphicon-eye-open"></span></button></a>
				                <a href="/admin/inventory/csvlink/box/{{$box->code}}"><button type="button" class="btn btn-xs btn-primary" title="print"><span class="glyphicon glyphicon-print"></span></button></a>
			                	<button onclick="delete_this('{{$box->code}}');" type="button" class="btn btn-xs btn-danger" title="delete"><span class="glyphicon glyphicon-trash"></span></button>
				            </td>
				        </tr>
				    @endforeach     
				    
				    </tbody>

				</table>
			</div>

			<table align="right">
			    <tr>
			        <td>
						{{ $boxes->links() }}
			        </td>
			    </tr>
			</table>

		@endif<!-- End of Boxes -->

		@if($type == 'items')
			<div class="panel panel-default">
				<div class="panel-heading"><span class="glyphicon glyphicon-list"></span> <font style="color:#2686ff">Items'</font> List</div>
				<table class="table table-striped table-bordered table-hover">
			   
			    <thead>
			        <tr>
			            <th>Id</th>
			            <th>CODE</th>
			            <th>NAME</th>
			            <th>QTY</th>
			            <th>DESCRIPTION</th>
			            <th>SELECT</th>
			        </tr>
			    </thead>
			   
			    <tbody>
			   
			    @foreach($items as $item)
			        <tr>
			            <td>
			                {{ $item->id }}
			            </td>
			            <td>
			                {{ $item->code }}
			            </td>
			            <td>
			                {{ $item->name }}
			            </td>
			            <td>
			                {{ $item->quantity }}
			            </td>
			            <td>
			                {{ $item->description }}
			            </td>
			            <td class="col-xs-3">
			                <a href="/admin/inventory/view/{{$item->code}}"><button type="button" class="btn btn-xs btn-info" title="view"><span class="glyphicon glyphicon-eye-open"></span></button></a>
			                <a href="/admin/inventory/csvlink/item/{{$item->code}}"><button type="button" class="btn btn-xs btn-primary" title="print"><span class="glyphicon glyphicon-print"></span></button></a>
			                <a href="/admin/inventory/lend/{{$item->id}}"><button type="button" class="btn btn-xs btn-success" title="lend"><span class="glyphicon glyphicon-share-alt"></span></button></a>
			                <button onClick="report_broken('{{$item->code}}');" type="button" class="btn btn-xs btn-warning" title="report broken"><span class="glyphicon glyphicon-warning-sign"></span></button>
			                <button onclick="delete_this('{{$item->code}}');" type="button" class="btn btn-xs btn-danger" title="delete"><span class="glyphicon glyphicon-trash"></span></button>
			            </td>
			        </tr>
			    @endforeach     
			    
			    </tbody>

			</table>

			<table align="right">
			    <tr>
			        <td>
						{{ $items->links() }}
			        </td>
			    </tr>
			</table>

		@endif<!-- End of Items -->

		@if($type == 'broken')
			<div class="panel panel-default">
				<div class="panel-heading"><span class="glyphicon glyphicon-list"></span> <font style="color:#2686ff">Broken items'</font> List</div>
				<table class="table table-striped table-bordered table-hover">
			   
			    <thead>
			        <tr>
			            <th>Id</th>
			            <th>CODE</th>
			            <th>NAME</th>
			            <th>QTY</th>
			            <th>DESCRIPTION</th>
			            <th>SELECT</th>
			        </tr>
			    </thead>
			   
			    <tbody>
			   
			    @foreach($broken_items as $broken_item)
			        <tr>
			            <td>
			                {{ $broken_item->id }}
			            </td>
			            <td>
			                {{ $broken_item->code }}
			            </td>
			            <td>
			                {{ $broken_item->name }}
			            </td>
			            <td>
			                {{ $broken_item->quantity }}
			            </td>
			            <td>
			                {{ $broken_item->description }}
			            </td>
			            <td>
			               <button onClick="fix_broken({{ $broken_item->id }});" type="button" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-saved"></span></button>
			               <button onclick="remove_broken({{ $broken_item->id }});" type="button" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
			            </td>
			        </tr>
			    @endforeach     
			    
			    </tbody>

			</table>

			<table align="right">
			    <tr>
			        <td>
						{{ $broken_items->links() }}
			        </td>
			    </tr>
			</table>

		@endif<!-- End of Broken Items -->

</div>

<script type="text/javascript">

</script>


@stop