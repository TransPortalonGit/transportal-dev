@extends('layouts.admin')

@section('head')

{{HTML::style('/css/admin-inventory-page.css')}}

<script type="text/javascript">

function return_this(id) 
{
    bootbox.confirm("Are you sure you want to return item from entry " + id + "?", function(result) {

        if(result==true) {
           window.location = "/admin/inventory/return/" + id
        }

    });
}

function delete_this(code) 
{
    bootbox.confirm("Are you sure you want to delete " + code + "?", function(result) {

        if(result==true) 
        {
           window.location = "/admin/inventory/delete/" + code
        }

    });
}

function dispose_broken(id)
{
     bootbox.confirm("Are you sure you want to dispose entry " + id + "?", function(result) {

        if(result==true) 
        {
           window.location = "/admin/inventory/dispose/" + id
        }

    });
}

</script>

@stop

@section('content')
<br />
<ol class="breadcrumb">
  <li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
  <li class="active">Inventory</li>
<hr>
</ol>

@if( Session::has('success') )
    <div class="alert alert-success" role="alert">  {{Session::get('success')}} </div>
@elseif( Session::has('error') )
    <div class="alert alert-danger" role="alert">  {{Session::get('error')}} </div>
@endif

<div class="row bg-color bg-img font-color">
    
    <div class="col-lg-2 col-md-6 bg-color bg-img font-color custom-center">
        <div class="panel panel-aqua bg-color bg-img font-color">
            <a href="/admin/inventory/list/items">
                <div class="panel-heading bg-color bg-img font-color">
                    <div class="row bg-color bg-img font-color">
                        <div class="col-xs-12 text-center bg-color bg-img font-color">
                            <div class="huge bg-color bg-img font-color"> {{ $item_count }} </div>
                            <div class="bg-color bg-img font-color">ITEMS</div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/admin/inventory/create/item" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Add More</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-plus-circle fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a>
            <a href="/admin/inventory/csvlink/item/0" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Print All</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-print fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a> 
        </div>
    </div>

    <div class="col-lg-2 col-md-6 bg-color bg-img font-color custom-center">
        <div class="panel panel-aqua bg-color bg-img font-color">
            <a href="/admin/inventory/list/boxes">  
                <div class="panel-heading bg-color bg-img font-color">
                    <div class="row bg-color bg-img font-color">
                        <div class="col-xs-12 text-center bg-color bg-img font-color">
                            <div class="huge bg-color bg-img font-color"> {{ $box_count }} </div>
                            <div class="bg-color bg-img font-color">BOXES</div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/admin/inventory/create/box" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Add More</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-plus-circle fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a>
            <a href="/admin/inventory/csvlink/box/0" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Print All</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-print fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a> 
        </div>
    </div>

    <div class="col-lg-2 col-md-6 bg-color bg-img font-color custom-center">
        <div class="panel panel-aqua bg-color bg-img font-color">
            <a href="/admin/inventory/list/surfaces">
                <div class="panel-heading bg-color bg-img font-color">
                    <div class="row bg-color bg-img font-color">
                        <div class="col-xs-12 text-center bg-color bg-img font-color">
                            <div class="huge bg-color bg-img font-color"> {{ $surface_count }} </div>
                            <div class="bg-color bg-img font-color">SURFACES</div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/admin/inventory/create/surface" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Add More</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-plus-circle fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a>
            <a href="/admin/inventory/csvlink/surface/0" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Print All</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-print fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a> 
        </div>
    </div>

    <div class="col-lg-2 col-md-6 bg-color bg-img font-color custom-center">
        <div class="panel panel-aqua bg-color bg-img font-color">
            <a href="/admin/inventory/list/cabinets">
                <div class="panel-heading bg-color bg-img font-color">
                    <div class="row bg-color bg-img font-color">
                        <div class="col-xs-12 text-center bg-color bg-img font-color">
                            <div class="huge bg-color bg-img font-color"> {{ $cabinet_count }} </div>
                            <div class="bg-color bg-img font-color">CABINETS</div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/admin/inventory/create/cabinet" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Add More</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-plus-circle fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a>   
            <a href="/admin/inventory/csvlink/cabinet/0" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Print All</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-print fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a>  
        </div>
    </div>

     <div class="col-lg-2 col-md-6 bg-color bg-img font-color custom-center">
        <div class="panel panel-aqua bg-color bg-img font-color">
            <a href="/admin/inventory/list/rooms">
                <div class="panel-heading bg-color bg-img font-color">
                    <div class="row bg-color bg-img font-color">
                        <div class="col-xs-12 text-center bg-color bg-img font-color">
                            <div class="huge bg-color bg-img font-color"> {{ $room_count }} </div>
                            <div class="bg-color bg-img font-color">ROOMS</div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="/admin/inventory/create/room" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Add More</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-plus-circle fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a>
            <a href="/admin/inventory/csvlink/room/0" class="font-color">
                <div class="panel-footer bg-color bg-img font-color">
                    <span class="pull-left font-color smaller">Print All</span>
                    <span class="pull-right font-color smaller"><i class="fa fa-print fa-lg"></i></span>
                    <div class="clearfix bg-color bg-img font-color"></div>
                </div>
            </a> 
        </div>
    </div>

</div>

<div class="adminpage-label">
    <h4><span class="fa fa-info-circle"></span> Active Lendings</h4>
</div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>CREATED</th>
            <th>USERNAME</th>
            <th>ITEM</th>
            <th>QUANTITY</th>
            <th>DUE DATE</th>
            <th>SELECT</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <?php $i = $i++ ?> 
        <tr>
            <td>
                {{ $transaction->id }}
            </td>
            <td>
                {{ $transaction->created_at }}
            </td>
            <td>
                {{ $users[$i]->username }}
            </td>
            <td>
                {{ $items[$i]->name }}
            </td>
            <td>
                {{ $transaction->quantity }}
            </td>
            <td>
                {{ $transaction->due_date }}
            </td>
            <td>
                <a href="/admin/inventory/view/T{{$transaction->id}}"><button type="button" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-eye-open"></span></button></a>
                <button onclick="return_this({{$transaction->id}})" type="button" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-saved"></span></button>
            </td>
        </tr>
    @endforeach     
    </tbody>
</table>
<table align="right">
    <tr>
        <td>
{{$transactions->appends(Request::except('page'))->links();}}
        </td>
    </tr>
</table>

<br />

<div class="adminpage-label">
    <h4><span class="fa fa-warning"></span> Broken Items</h4>
</div>

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
               <button onclick="dispose_broken({{ $broken_item->id }});" type="button" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
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

@stop