@extends('layouts.master')

@section('content')
  <div class="pwd-box">
    <h3>Password Management</h3>
    <ul style="list-style: none;">
      <li>
        <div><p>Current password</p></div>
        <div class="form-group">
          <input type="password" class="form-control" id="password-field">
        </div>
      </li>
      <li>
        <div><p>New password</p></div>
        <div class="form-group">
          <input type="password" class="form-control" id="password-field">
        </div>
      </li>
      <li>
        <div><p>Retype new password</p></div>
        <div class="form-group">
          <input type="password" class="form-control" id="password-field">
        </div>
      </li>
    </ul>
    <div>
      <button style="width:80px; background-color: #34a26a;" type="button" class="btn btn-success">Save</button>
      <button style="width:80px;" type="button" class="btn btn-warning">Cancel</button>

    </div>
  </div>
@stop