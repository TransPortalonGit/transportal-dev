@extends('layouts.admin')

@section('head')

<script type="text/javascript">

</script>

@stop

@section('content')

<!-- Calculations -->

<?php 
$activeusers_pcnt = (count($activeusers))/(count($users))*100;
$inactiveusers_pcnt = (count($inactiveusers))/(count($users))*100;  
?>

@foreach($items as $item)
<?php $totalarticles = $totalarticles+$item->quantity ?>
@endforeach

@foreach($itemsusers as $itemsuser)
<?php $totalarticles = $totalarticles+$itemsuser->quantity ?>
@endforeach

@foreach($itemsusers as $itemsuser)
<?php $totalarticlesloaned = $totalarticlesloaned+$itemsuser->quantity ?>
@endforeach

<?php
if($totalarticles != 0) {

	$totalarticlesloaned_pcnt = ($totalarticlesloaned)/($totalarticles)*100;
	if($totalarticlesloaned < $totalarticles) {
	$totalarticlesstored_pcnt = (($totalarticles)-($totalarticlesloaned))/($totalarticles)*100;
	} else {
	$totalarticlesstored_pcnt = (($totalarticlesloaned)-($totalarticles))/($totalarticles)*100;
	} } else {
		$totalarticlesloaned_pcnt = 0;
		$totalarticlesstored_pcnt = 0;
	}


?>

<!-- End of Calculations -->

<br />

<ol class="breadcrumb">
  <li><i class="fa fa-home home-btn"></i><a href="/admin"> Home</a></li>
  <li class="active">Dashboard</li>
<hr>
</ol>

	<h3> Quick Stats </h3>

	<p><h4>Users ({{count($users)}}):</h4></p>
	
	<div class="progress">
	  <div class="progress-bar progress-bar-success" style="width: {{$activeusers_pcnt}}%">
	    <span class="sr-only">{{$activeusers_pcnt}}% Complete (success)</span>
	  </div>
	  <div class="progress-bar progress-bar-warning" style="width: {{$inactiveusers_pcnt}}%">
	    <span class="sr-only">{{$inactiveusers_pcnt}}% Complete (warning)</span>
	  </div>
	  <div class="progress-bar progress-bar-danger" style="width: 0%">
	    <span class="sr-only">0% Complete (danger)</span>
	  </div>
	</div>

	<i class="fa fa-square" style="color: #5cb85c"></i> Active: {{count($activeusers)}} | <i class="fa fa-square" style="color: #f0ad4e"></i> Inactive: {{count($inactiveusers)}} | <i class="fa fa-square" style="color: #d9534f"></i> Blocked: 0

	<p><h4>Items (total quantity [{{$totalarticles}}]):</h4></p>
	
	<div class="progress">
	  <div class="progress-bar progress-bar-success" style="width: {{$totalarticlesstored_pcnt}}%">
	    <span class="sr-only">{{$totalarticlesstored_pcnt}}% Complete (success)</span>
	  </div>
	  <div class="progress-bar progress-bar-warning" style="width: {{$totalarticlesloaned_pcnt}}%">
	    <span class="sr-only">{{$totalarticlesloaned_pcnt}}% Complete (warning)</span>
	  </div>
	  <div class="progress-bar progress-bar-danger" style="width: 0%">
	    <span class="sr-only">0% Complete (danger)</span>
	  </div>
	</div>

	<i class="fa fa-square" style="color: #5cb85c"></i> Stored: {{(($totalarticles)-($totalarticlesloaned))}} | <i class="fa fa-square" style="color: #f0ad4e"></i> Loaned: {{$totalarticlesloaned}} | <i class="fa fa-square" style="color: #d9534f"></i> Lost: 0

	<p><h4>Website:</h4></p>
	<p> - Total posts, comments, etc </p>

	<p><h4>Activity:</h4></p>
	<div class="log-label"><p>Activity logs</p></div>
	<div class="activity-log">
		<ul style="list-style:none;">

			<!--Note the different id/icon for different type of info-->

			<li><i id="info" class="fa fa-info-circle"> </i> [01-03-2014, 13:03:22] Inventory list has been updated. 05 items has been added by admin <em><strong>Stefanos</strong></em>.</li>
			<li><i id="warning" class="fa  fa-exclamation-circle"> </i> [01-03-2014, 13:03:22] User list has been updated.  01 has been added by admin <em><strong>Simon</strong></em>.</li>
			<li><i id="danger" class="fa fa-times-circle"> </i> [01-03-2014, 13:03:22] Inventory list has been updated. 05 items has been blocked by admin <em><strong>Stefanos</strong>.</em></li>
			<li><i id="danger" class="fa fa-times-circle"> </i> [01-03-2014, 13:03:22] Inventory list has been updated. 05 items has been blocked by admin <em><strong>Stefanos</strong></em>.</li>
			<li><i id="warning" class="fa  fa-exclamation-circle"> </i> [01-03-2014, 13:03:22] User list has been updated.  01 has been added by admin <em><strong>Simon</strong></em>.</li>

		</ul>
	</div>

	<br>
	<div class="inlab-label"><p>People in lab</p></div>
	<div class="inlab-log">
		 @if($usersinlab)
                @foreach($usersinlab as $userinlab)
                  @if($userinlab->incognito == 0) 
                      <div class="portrait"> <img  alt="" src="/profile-pics/{{$userinlab->profile_pic}}"> </div>           
              @endif
                @endforeach
              @else
                    <p>{{ $userinlab->username }} The lab is empty. :(</p>
              @endif	
	</div>

	

@stop