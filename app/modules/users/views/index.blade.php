@extends('layouts.admin')

@section('head')

<script type="text/javascript">

function delete_user(id, username) {
    bootbox.confirm("Are you sure you want to delete " + username + "?", function(result) {

        if(result==true) {
           window.location = "/admin/users/delete/" + id + "/" + encodeURIComponent(username);
        }

    }); 
}

function edit_user(id) {
    window.location = "/admin/users/edit/" + id;
}

function view_user(id) {
    window.location = "/admin/users/view/" + id;
}

function activate_user(id) {
    window.location = "/admin/users/activate/" + id;
}

</script>

@stop

@section('content')

<br />

<ol class="breadcrumb">
  <li><span class="fa fa-home home-btn"></span><a href="/admin"> Home</a></li>
  <li class="active">Users</li>
<hr>
</ol>

    <div class="adminpage-label">
        <h4><span class="fa fa-user"></span> Users List</h4>
    </div>


    <div class="adminpage-sorter">  
       
            <div style="float: left;"><a href="/admin/users/add"><button type="submit" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> add user</button></a></div>
            <div> 
                <form method="GET" id="pagination" title="number of items shown">
                    <select class="form-control" name="usrsperpage" id="usrsperpage" style="margin-right: 5px;">
                      <option value="5" @if($usrsperpage == 5) selected @endif>5</option>
                      <option value="10" @if($usrsperpage == 10) selected @endif>10</option>
                      <option value="15" @if($usrsperpage == 15) selected @endif>15</option>
                      <option value="25" @if($usrsperpage == 25) selected @endif>25</option>
                      <option value="35" @if($usrsperpage == 35) selected @endif>35</option>
                    </select> 
            </div>
            <div style="float: right;">                 
                    <select class="form-control" name="sortby" id="sortby">
                      <option value="id" @if($sortby == 'id') selected @endif>Id</option>
                      <option value="username" @if($sortby == 'username') selected @endif>Username</option>
                      <option value="Role" @if($sortby == 'Role') selected @endif>Role</option>
                      <option value="activated" @if($sortby == 'activated') selected @endif>Account</option>
                    </select>
                </form>
            </div>
    </div>




<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>Username</th>
			<th>E-mail</th>
			<th>Account</th>
			<th>Role</th>
            <th>Controls</th>
		</tr>
	</thead>
	<tbody>
    @foreach($users as $user)
    	<tr>
    		<td>
        		{{ $user->username }}
    		</td>
    		<td>
        		{{ $user->email }}
    		</td>
			<td>
        		@if($user->activated)
        		activated
        		@else
        		inactive
        		@endif
    		</td>
    		<td>
        		@if ($user->hasAccess("is_admin"))
                admin       
                @else
                member      
                @endif
    		</td>
            <td>
                <button onClick="view_user({{ $user->id }});" type="button" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-eye-open"></span> View</button>
                <button onClick="edit_user({{ $user->id }});" type="button" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-wrench"></span> Edit</button>
                <button onclick="delete_user({{ $user->id }}, '{{ $user->username }}');" type="button" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                @if($user->activated)
                <button onClick="block_user({{ $user->id }});" type="button" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Block</button>
                @else
                <button onClick="activate_user({{ $user->id }});" type="button" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-ok-sign"></span> Activate</button>
                @endif
            </td>
		</tr>
    @endforeach		
	</tbody>
</table>
<table align="right">
    <tr>
        <td>
{{$users->appends(Request::except('page'))->links();}}
        </td>
    </tr>
</table>

<script type="text/javascript">

$('#usrsperpage').change(
    function() {
        $('#pagination').trigger('submit');
});

$('#sortby').change(
    function() {
        $('#pagination').trigger('submit');
});

</script>

@stop