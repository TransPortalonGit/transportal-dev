@extends('layouts.master')
@section('head')

	{{HTML::script('/js/Chart.js')}}
	

		
@stop

@section('content')
<div class="row">
	
		<div class="content_container container">

			@include('site.profile._user_profileheader')			

			@include('site.profile._user_navigation')
			
			<div class="card-wrapper">
				<div class="left-cards">
					<div id="usage-info" style="border: 1px solid #345CA2; ">
						<div style="background-color: #345CA2;"><p>Hours spent in lab</p></div>
						<canvas id="canvas-hour" height="200" width="450"></canvas>
						<script>
							var lineChartData = {
								labels : ["January","February","March","April","May","June","July"],
								datasets : [
									{
										fillColor : "rgba(220,220,220,0.5)",
										strokeColor : "rgba(220,220,220,1)",
										pointColor : "rgba(220,220,220,1)",
										pointStrokeColor : "#fff",
										data : [65,59,90,81,56,55,40]
									},
									{
										fillColor : "rgba(151,187,205,0.5)",
										strokeColor : "rgba(151,187,205,1)",
										pointColor : "rgba(151,187,205,1)",
										pointStrokeColor : "#fff",
										data : [28,48,40,19,96,27,100]
									}
								]
								
							}

						var myLine = new Chart(document.getElementById("canvas-hour").getContext("2d")).Line(lineChartData);
						
						</script>

					</div>
					<div id="usage-info" style="border: 1px solid  #B43131; "> 
						<div style="background-color: #B43131;"><p>Various activities</p></div>
						<canvas id="canvas-length" height="200" width="450"></canvas>
						<script>

							var radarChartData = {
								labels : ["Eating","Drinking","Sleeping","Designing","Coding","Partying","Running"],
								datasets : [
									{
										fillColor : "rgba(220,220,220,0.5)",
										strokeColor : "rgba(220,220,220,1)",
										pointColor : "rgba(220,220,220,1)",
										pointStrokeColor : "#fff",
										data : [65,59,90,81,56,55,40]
									},
									{
										fillColor : "rgba(151,187,205,0.5)",
										strokeColor : "rgba(151,187,205,1)",
										pointColor : "rgba(151,187,205,1)",
										pointStrokeColor : "#fff",
										data : [28,48,40,19,96,27,100]
									}
								]
								
							}

						var myRadar = new Chart(document.getElementById("canvas-length").getContext("2d")).Radar(radarChartData,{scaleShowLabels : false, pointLabelFontSize : 10});
						
						</script>

					</div>
				</div>

				<div class="right-cards">
					<div id="usage-info" style="border: 1px solid #832C7C; ">
						<div style="background-color: #832C7C;"><p>Some statistics</p></div>
						<canvas id="canvas1" height="200" width="200"></canvas>
						<script>

							var doughnutData = [
									{
										value: 30,
										color:"#F7464A"
									},
									{
										value : 50,
										color : "#46BFBD"
									},
									{
										value : 100,
										color : "#FDB45C"
									},
									{
										value : 40,
										color : "#949FB1"
									},
									{
										value : 120,
										color : "#4D5360"
									}
								
								];

						var myDoughnut = new Chart(document.getElementById("canvas1").getContext("2d")).Doughnut(doughnutData);
						
						</script>

					</div>
					<div id="usage-info" style="border: 1px solid  #83522C; "> 
						<div style="background-color: #83522C;"><p>Other figures</p></div>
						<canvas id="canvas2" height="200" width="450"></canvas>
						<script>

							var barChartData = {
								labels : ["January","February","March","April","May","June","July"],
								datasets : [
									{
										fillColor : "rgba(220,220,220,0.5)",
										strokeColor : "rgba(220,220,220,1)",
										data : [65,59,90,81,56,55,40]
									},
									{
										fillColor : "rgba(151,187,205,0.5)",
										strokeColor : "rgba(151,187,205,1)",
										data : [28,48,40,19,96,27,100]
									}
								]
								
							}

						var myLine = new Chart(document.getElementById("canvas2").getContext("2d")).Bar(barChartData);
						
						</script>

					</div>
				</div>
			</div>

		</div>
	
</div>


@stop