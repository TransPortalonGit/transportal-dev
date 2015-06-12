@extends('layouts.master')
@section('head')

{{HTML::style('/css/fullcalendar.css')}}
<!-- {{HTML::style('/css/fullcalendar.print.css')}} -->
{{HTML::style('/css/bootstrap-dialog.min.css')}}
{{HTML::style('/css/jquery.datetimepicker.css')}}
{{HTML::script('/js/fullcalendar.js')}}
{{HTML::script('/js/jquery-ui.custom.min.js')}}
{{HTML::script('/js/jquery.datetimepicker.js')}}

<!-- {{HTML::script('/js/bootstrap.min.js')}} --> <!-- Makes navbar unresponsive -->

<!-- //{{HTML::style('/css/bootstrap.min.css')}} -->
{{HTML::script('/js/bootstrap-dialog.min.js')}}
{{HTML::script('/js/momentjs.js')}}
{{HTML::script('/js/collapse.js')}}
{{HTML::style('/css/bootstrap-slider.css')}}
{{HTML::script('/js/bootstrap-slider.js')}}
{{HTML::script('/css/slider.less')}}
        
	<script type="text/javascript"> 
        
        function getPopUpDeleteButton(userid, id) {
            @if (Sentry::getUser()->hasAccess('admin'))
                return "<button onclick=confirmDelete("+id+") class= 'btn btn-danger'>Delete</button>"
            @endif
            if ({{Sentry::getUser()->id}} == userid) {
                return "<button onclick=confirmDelete("+id+") class= 'btn btn-danger'>Delete</button>"
            } else {
                return "";
            }
        }
        
        function getPopUpNotesDiv(notes) {
            if (notes != "") {
                return "<div style='background-color: #f5f5f5;margin-top: 10px; padding-left:10px;padding-top: 10px; padding-bottom: 10px'>"+notes+"</div>"
            } else {
                return "";
            }
        }
        
        function zeroPad(n) {
            return (n < 10 ? '0' : '') + n;
        }
        
        function getTime(date) {
            var date = new Date(date);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            return zeroPad(hours)+":"+zeroPad(minutes);
        }
        
        function getReservation(id) {
            var appointments = {{ $appointments }};
            for (i = 0; i < appointments.length ; i++) {
                if (appointments[i].user_id === id) {
                    return appointments[i].start;
                }
            }
        }

        function getMachineName(id) {
            var machines = {{ $machines }};
            for (i = 0; i < machines.length ; i++) {
                if (machines[i].id === id) {
                    return machines[i].name;
                }
            }
        }
        
        function getUserFirstName(id) {
            var users = {{ $users }};
            for (i = 0; i < users.length ; i++) {
                if (users[i].id === id) {
                    return users[i].first_name;
                }
            }
        }
        
        function getUserLastName(id) {
            var users = {{ $users }};
            for (i = 0; i < users.length ; i++) {
                if (users[i].id === id) {
                    return users[i].last_name;
                }
            }
        }
		
		function getUsername(id) {
            var users = {{ $users }};
            for (i = 0; i < users.length ; i++) {
                if (users[i].id === id) {
                    return users[i].username;
                }
            }
        }
        
        function getUserPicture(id) {
            var users = {{ $users }};
            for (i = 0; i < users.length ; i++) {
                if (users[i].id === id) {
                    return users[i].profile_pic;
                }
            }
        }
        
        function getEventTitle(item_id, user_id, notes) {
            if (item_id == 4){
                return "<div>"+notes+"</div>"
            } else {
                return "<div>" +getUserFirstName(user_id) + ' ' +getFirstLetter(getUserLastName(user_id))+'.' +"</div>"
            }
        }
        
        function getFirstLetter(x) {
            return x.charAt(0);
        }
                
		/**
		* Returns the max date that is allowed in the calender (Today+12, no sunday)2
		**/
		function getMaxDate() {
			var today = new Date();
			var day = today.getDay();
			var diff = today.getDate() - day + (day == 0 ? - 6:1);
			var monday = new Date(today.setDate(diff));
			var date = monday.getDate()+12;
			var month = monday.getMonth()+1;
			var year = monday.getYear()+1900;
			
			if ( /*month == 4 || month == 6 || month == 9 || month == 11 && */date > 30) { // NOT ACCURATE YET FOR FEBRUARY!!!
				date = date-30;
				month = month+1;
			} /*else if (month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12 && date > 30){
				date = date-31;
				month = month+1;
			} */
			
			if (month > 12) {
				month = month - 12;
				year = year+1;
			}
			
			if (month <= 9) {
				var temp = month;
				month = new String();
				month = "0"+temp;
			}
			
			if (date <= 9) {
				temp = date;
				date = new String();
				date = "0"+temp;
			}
			
			var limit = new String();
			
			return limit = year+'/'+month+'/'+date;
		}
        function confirmDelete(event_id) {
            BootstrapDialog.show({
                title: 'Warning!',
                message: 
                'Do you really want to delete this event?'
                +'<br><br>'
                +'{{ Form::open(array('action' => 'profile\AppointmentController@del')) }}'
                +'<input type="hidden" name="id" value="'
                +event_id+'">'
                +'<button type ="submit" class="btn btn-danger"= submit>Delete</button>'
                +'{{ Form::close() }}',
                type: BootstrapDialog.TYPE_DANGER,
            });
        }
        
        function open_modal($e_start,$e_end,$e_user_id, $e_item_id, $e_title, $e_id){
	        BootstrapDialog.show({
						title: "<span class='glyphicon glyphicon-time' style='margin: 0 auto;'></span>"
                            +'  '+getTime($e_start)+' - '+getTime($e_end),
						message:
                            "<a href='show/"+getUsername($e_user_id)+"'><img src='/profile-pics/"+getUserPicture($e_user_id)+"' height='89px' width='89px' class='img-responsive img-thumbnail' alt='Responsive image' style=''></a>"
                            +"<div style='display: inline-block; width: 238px; height: 89px; margin-left: 10px; padding-top: 12px; padding-bottom: 35px; padding-left: 10px; padding-right: 10px; background-color: #f5f5f5;'> Name: "+getUserFirstName($e_user_id)+" "+getUserLastName($e_user_id)
                            +"<br> Machine: "+getMachineName($e_item_id)+"</div>"
                            +getPopUpNotesDiv($e_title)
                            +'<hr>'
                            +getPopUpDeleteButton($e_user_id, $e_id)
                            +'   '
                            +'<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>',
                        });
        }
		
        $(function(){
            
            // FILTERSELECT ONCHANGE
            $("#filterSelect").change(function(e) {
                $(this).parents("form").submit()
            }); 
			
			$(".checkbox").change(function(e) {
                $(this).parents("form").submit()
            }); 
            
        	// Function date and time picker
            $(".set-date1").hide();
            $("#appnt").click(function(){
		    	$(".set-date1").toggle();
		  	});
		  	$("#done1").click(function(){
		  		$(".set-date1").hide();
		  	});

		  	$(".set-date2").hide();
		  	$("#resv").click(function(){
		  		$(".set-date2").toggle();
		  	});
		  	$("#done2").click(function(){
		  		$(".set-date2").hide();
		  	});

		  	//The info box for user without reservation permission

		  	$(".info-box").hide();
		  	$("#resv1").click(function() {
		  		$(".info-box").toggle();
		  	});
			

		  	// Selecting different machines for displaying time slot
		  	/*
		  	$("#machine-choice").change(function(){
		  			    

			  		if ($(this).val() == "3D printer") {

			  			$(".3P-table").toggle();
			  			$(".CS-table, .PG-table, .LC-table, .calendar").hide();		

			  			
			  		}
			  		else if ($(this).val() == "Laser cutter") {
			  			$(".LC-table").toggle();
			  			$(".CS-table, .PG-table, .3P-table , .calendar").hide();
			  			
			  		}
			  		else if ($(this).val() == "Chainsaw") {
			  			$(".CS-table").toggle();
			  			$(".LC-table, .PG-table, .3P-table, .calendar").hide();

			  		}
			  		else if ($(this).val() == "Portal gun") {
			  			$(".PG-table").toggle();
			  			$(".LC-table, .CS-table, .3P-table, .calendar").hide();
			  			
			  		}
			  		
			  		else {
			  			$(".LC-table, .CS-table, .PG-table, .3P-table").hide();
			  			location.reload();
			  			
			  		}
			  		
			  	}); */

			
			//onClick week Buttons
			$('.span.fc-button.fc-button-prev').click(function(){
				alert('prev is clicked, do something');
			});

			$('.fc-button-next span').click(function(){
				alert('nextis clicked, do something');
			});

			  
		  	//Loads calendar

			
				var date = new Date();
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();
				
				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next',
						center: 'title',
						right: ''
					},
					editable: false,
					/////////////////Feed event data in this events var//////////////////////
					events: {{ $appointments }},
					eventRender: function(event, element) {
						var imgUrl; 
						
						if(event.item_id == 2){
							imgUrl = 'lc_wide.svg';
						}
						if(event.item_id == 3){
							imgUrl = 'vc_wide.svg';
						}
						if(event.item_id == 4){
							imgUrl = 'vip_wide.svg';
						}
                        if(event.item_id == 5){
							imgUrl = '3d_wide.svg';
						}
                        if(event.item_id == 6){
							imgUrl = '3d_wide.svg';
						}
                        if(event.item_id == 7){
							imgUrl = '3d_wide.svg';
						}
                        if(event.title == "") {
                            $(element).css({
                                "background-image": "url(../items/"+ imgUrl +")",
                                "background-repeat": 'no-repeat',
                                //"opacity":"0.5";
                                "background-size": '25px 25px',
                                "background-position": 'bottom right'
                            });
                        } else {
                            $(element).css({
                                "background-image": "url(../items/"+ imgUrl +"), url(../items/comment_80.png)",
                                "background-repeat": 'no-repeat, no-repeat',
                                //"opacity":"0.5";
                                "background-size": '25px 25px, 23px 12px',
                                "background-position": 'bottom right, bottom left',
                            });
                        }
                        element.find('.fc-event-title').after(
                            getEventTitle(event.item_id, event.user_id, event.title)
                        );
                        
                        $('.fc-event-title').hide();
						//$('.fc-event-time').hide();
					},
					eventClick: function(event) {
							open_modal(event.start, event.end, event.user_id, event.item_id, event.title, event.id);
					},
			        //////////////////////////////////////////////////////////////
					hiddenDays: [0],
					defaultView: 'agendaWeek',
					minTime: '8:00',
					maxTime: '20:00',
					allDaySlot: false,
					slotEventOverlap: false,
                    allDayDefault: false,
					timeFormat: 'HH:mm{ - HH:mm}',
					axisFormat: 'HH:mm',
                });
			});
    </script>
	<style>
        .modal {
            padding-top: 10%;
            padding-left: 18%;
        }
   
		.modal-content {
			width: 400px;
		}
		
		.panel-default{
			 width: 115%;
		}
	</style>
	
@stop

@if(Session::has('messageAlert'))
<p class="alert alert-danger alert-dismissable">{{ Session::get('messageAlert') }}
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>
@endif

@if(Session::has('messageConfirm'))
<p class="alert alert-success">{{ Session::get('messageConfirm') }}
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>
@endif

@section('content')
<div class="row">
	<div class="col-xs-12"> 
		<div class="content_container container">

			@include('site.profile._user_profileheader')			

			@include('site.profile._user_navigation')
			
			
		 <div class="appointment-wrapper">	
			<!--<div class="add-appointment" style="background-color: #ffffff; border-radius:10px 10px 0px 0px;"> -->
            
            <!-- MACHINE FILTER -->
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Filter</h3>
  </div>
  <div class="panel-body">				
                {{ Form::open(array('action' => 'profile\AppointmentController@filter')) }}
                
                    @foreach($machines as $m)
                        @if ($m->type != "PrivateCircle") <!-- Private Circle is an exception -->
                            @if ($m->name == "Ultimaker-1")
                                {{ Form::checkbox($m->type,$m->type,true, array('class'=>'checkbox', 'style'=>'float: left; margin-right: 5px'))}} 
                                <div><img src="../items/3d.svg" alt="3D-Printer" width="25" height="25" margin="1">   <span style="background-color:#738ffe; color: white">3D-Printer </span></div><br>
                            @endif
                                
                            @if ($m->name == "Lasercutter")
                                {{ Form::checkbox($m->type,$m->type,true, array('class'=>'checkbox', 'style'=>'float: left; margin-right: 5px'))}} 
                                <div><img src="../items/lc.svg" alt="Lasercutter" width="25" height="25" margin="1">   <span style="background-color:#ec407a; color: white">Lasercutter </span></div><br>
                            @endif
                            
                            @if ($m->name == "Vinylcutter")
                                {{ Form::checkbox($m->type,$m->type,true, array('class'=>'checkbox', 'style'=>'float: left; margin-right: 5px'))}} 
                                <div><img src="../items/vc.svg" alt="Vinylcutter" width="25" height="25" margin="1">   <span style="background-color:#7dcea4; color: white">Vinylcutter </span></div><br>
                            @endif
                              
                        @endif
                    @endforeach
                    
                {{ Form::close() }}
			
			</div>
			</div>
                
                            <!-- Own reservations -->

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePanel">
          Own reservations<span class="caret"></span>
        </a>
      </h3>
    </div>
    <div id="collapsePanel" class="panel-collapse collapse">
      <div class="panel-body">
        <?php for($i = 0; $i < count($userAppointments); $i++){
     echo ("<button type ='button' onClick= open_modal('1','2','".$userAppointments[$i]['user_id']."','".$userAppointments[$i]['item_id']."','".$userAppointments[$i]['title']."','".$userAppointments[$i]['id']."') class='btn btn-default'= submit>".$userAppointments[$i]['start']."</button> <br />\n");   
}
?>	
      </div>
    </div>
  </div>
          
          
          		<!-- </div>
			<div class="add-appointment"> -->
                
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Make reservation</h3>
  </div>
  <div class="panel-body">				
                <!--/ Make appointment form via post -->
                {{ Form::open(array('action' => 'profile\AppointmentController@submit')) }}
                
                    <div  style="width: 200px; margin-bottom: 10px; margin-top: 10px">
						<div class="input-group">
						    <div class="input-group-addon"><i id="show-date1" class="fa fa-clock-o"></i></div>
							<input id="datetimepicker1" name="start_time" class="form-control" type="text" style="width: 160px;"readonly>		    
						</div>
				    </div>
                    {{ ($errors->first('start_time')) ? '<p class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				A starting time is required</p>': ''}}
					<div style="margin-left: 10px">
                        Duration: <span id="durationVal">0:30 hours</span>
                    </div>
					<div style="margin-bottom: 10px; margin-top: 10px; margin-left: 23px">
						<input id="duration"
						name="duration" 
						data-slider-id='duration' 
						type="text" data-slider-min="30" 
						data-slider-max="600" 
						data-slider-step="30" 
						data-slider-value="30" 
						value="30"/>
					</div>
<!--                     {{ $errors->first('duration', '<div style="color:white; background-color:#ec407a">:message</div>') }} -->
					<script type="text/javascript">
						$('#duration').slider({
                            tooltip: 'always'
                        });
                        $("#duration").on('slide', function(slideEvt) {
                            var minutes = (slideEvt.value%60) == 0 ? "00" : ""+slideEvt.value % 60;
                            var hours = Math.floor(slideEvt.value/60);
                            var time = hours+":"+minutes + " hours";
                            $("#durationVal").text(time);
                        });
				    </script>
					<div style="width: 200px; margin-bottom: 10px;">
                        <select name="machine" id="machineSelect" class="form-control">
                        <option value="" disabled selected style='display:none;'>Select a machine</option>
                        @if (Sentry::getUser()->hasAccess('admin'))
                                <option style="background-color: #bdbdbd; color: white;" value=4>Private Circle</option>
                        @endif
                        @foreach($machines as $m)
                            @if ($m->name != "PrivateCircle")
                                <option value={{$m->id}} >{{$m->name}}</option>
                            @endif
                        @endforeach
                        </select>
						<!--{{ Form::select('machine',$equips_list) }}-->
					</div>
                   
                    {{ ($errors->first('machine')) ? '<p class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				A machine is required</p>': ''}}
                    <div style="width: 200px; margin-bottom: 10px; margin-top: 10px">
                        {{ Form::textarea('title', null, array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'Write comments here..')) }}
                    </div>
					
                    <!--{{ Form::submit('Submit') }} -->
					<button type ="submit" class="btn btn-success btn-sm" style="margin-bottom: 10px">Submit</button>
                {{ Form::close() }}
				<!--
			    @if (Sentry::getUser()->hasAccess('3d_printer') || Sentry::getUser()->hasAccess('lasercutter'))			 
				
				<button type="button" id="resv" class="btn btn-primary">Make reservation <span class="caret"></span></button>
					<form role="form" class="set-date2" style="margin-top: 10px;">
						<select id= "machine-choice" class="form-control" style="border: 1px solid #ccc; margin-bottom: 10px;">
						  <option value="Choose machine" >Choose machine</option>
						  @if (Sentry::getUser()->hasAccess('3d_printer'))
						  <option value="3D printer" >3D printer</option>
						  @endif
						  @if (Sentry::getUser()->hasAccess('lasercutter'))
						  <option value="Laser cutter" >Laser cutter</option>
						  @endif
						   <option value="Portal gun" >Portal Gun</option>
						 
						</select>
				    	<div  style="width: 200px; margin-bottom: 10px;">				    					    
						    <input id="datetimepicker2" type="text" style="width: 180px;" readonly>
						    <i id="show-date2" class="fa fa-clock-o"></i>			    
				    	</div>
				    	<button type="submit" id="done2" class="btn btn-primary">submit</button>
			    	</form>
			    @else
			    <button type="button" id="resv1" class="btn btn-primary">Make reservation <span class="caret"></span></button>
			    <br>
			    <div class="info-box">
			    	<div>
			    		<p style="background-color:#4b4b4b; font-size: 12px; color: #ffffff; text-align: left; border: 1px solid #4b4b4b;">
			    			You need to get the mandatory introduction course to book these machines. Contact our <a href="/home" style="color: #BBE2BB;"><strong>admin</strong></a> to arrange the course.</p>
			    	</div>


			    </div>
			    @endif-->

			</div>
		</div>
		<!--</div>-->
			</div>
		

		<div class="calendar-wrapper">
			<div class="calendar">
				<div id="calendar"></div>
			</div>
			<!--
			<div class="3P-table">
				<h3>Time slots for 3D Printer</h3>
				<div id="3P-table"> </div>
			</div> 
			<div  class="LC-table">
				<h3>Time slots for Laser cutter</h3>
				<div id="LC-table"></div>
			</div> 
			<div  class="CS-table">
				<h3>Time slots for Chainsaw</h3>
				<div id="CS-table"></div>
			</div> 
			<div class="PG-table">
				<h3>Time slots for Portal gun</h3>
				<div id="PG-table" ></div>
			</div> 	-->		
		</div>
		

		
		    

		    <script type="text/javascript">
                
                /**
                * Returns the current time in a 'Y/m/d H:i' format
                */
                function getCurrentTime() {
                    var today = new Date();
                    var date = today.getDate();
                    var month = today.getMonth()+1;
                    var year = today.getYear()+1900;
                    var hours = today.getHours();
                    var minutes = today.getMinutes() - (today.getMinutes() % 30);
                    var tempString = new String();
                    return tempString = (year+'/'+zeroPad(month)+'/'+zeroPad(date)+' '+zeroPad(hours)+':'+zeroPad(minutes));
                }
                
		    	$('#datetimepicker1').datetimepicker({
                    value: getCurrentTime(),
                    format:'Y/m/d H:i',
		    		allowTimes:['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00',
		    		'13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30',
		    		'19:00', '19:30',],
		    		 minDate:'-1970/01/01',
					 maxDate: getMaxDate(),
		    		 dayOfWeekStart: 1,
		    		 step: 30,

		    	});
		    	$('#show-date1').click(function(){
				  $('#datetimepicker1').datetimepicker('show'); //support hide,show and destroy command
				});

				$('#datetimepicker2').datetimepicker({
		    		allowTimes:['9:00', '10:00', '11:00', '12:00',
		    		'13:00', '14:00', '15:00', '16:00', '17:00', '18:00',
		    		'19:00',],
		    		 minDate:'-1970/01/01',
					 maxDate: getMaxDate(),
		    		 dayOfWeekStart: 1,

		    	});
		    	$('#show-date2').click(function(){
				  $('#datetimepicker2').datetimepicker('show'); //support hide,show and destroy command
				});
				
				$('#datetimepicker3').datetimepicker({
		    		allowTimes:['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30',
		    		'13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30',
		    		'19:00', '19:30',],
		    		 minDate:'-1970/01/01', 
					 maxDate: getMaxDate(),
		    		 dayOfWeekStart: 1,

		    	});
		    	$('#show-date3').click(function(){
				  $('#datetimepicker3').datetimepicker('show'); //support hide,show and destroy command
				});
				
				$('#datetimepicker4').datetimepicker({
		    		allowTimes:['9:00', '10:00', '11:00', '12:00',
		    		'13:00', '14:00', '15:00', '16:00', '17:00', '18:00',
		    		'19:00',],
		    		 minDate:'-1970/01/01',
					 maxDate: getMaxDate(),					 
		    		 dayOfWeekStart: 1,

		    	});
		    	$('#show-date4').click(function(){
				  $('#datetimepicker4').datetimepicker('show'); //support hide,show and destroy command
				});

		    </script>

		    <!-- All available options for date/time picker

		    <script type="text/javascript">
				
				$('#datetimepicker').datetimepicker({
				value:'',
				lang:'en',
				format:'Y/m/d H:i',
				formatTime:'H:i',
				formatDate:'Y/m/d',
				step:60,
				closeOnDateSelect:0,
				closeOnWithoutClick:true,
				timepicker:false,
				datepicker:true,
				minDate:false,
				maxDate:false,
				minTime:false,
				maxTime:false,
				allowTimes:[],
				opened:false,
				inline:true,
				onSelectDate:function(){},
				onSelectTime:function(){},
				onChangeMonth:function(){},
				onChangeTime:function(){},
				onShow:function(){},
				onClose:function(){},
				withoutCopyright:true,
				inverseButton:false,
				hours12:false,
				next:'xdsoft_next',
				prev : 'xdsoft_prev',
				dayOfWeekStart:0,
				timeHeightInTimePicker:25,
				});

				$('#show-date').click(function(){
				  $('#dtBox').datetimepicker('show'); //support hide,show and destroy command
				});
			</script>

		-->
		   

		



		</div>
	</div>
</div>
@stop