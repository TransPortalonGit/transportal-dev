	<meta http-equiv="cleartype" content="on">
	
	<meta name="application-name" content="TransPortal" />

	<meta name="robots" content="noindex,nofollow" />
	<meta name="googlebot" content="noindex,nofollow" />

	<meta name="author" content="Dr. -Ing. Dennis Krannich, Carel Nantcho, Xiaofen Peng, Raksmey Meas, Simon Engelbertz, Stefanos-Rafail Trialonis" />
	<meta name="description" content="Multipurpose platform uniquely designed for FabLab users and personel" />
	<meta name="keywords" content="DIY, social, crafty, share, document, connect, dimeb, fablab, Uni Bremen, bremen, Universität Bremen" />

	<meta name="handheldfriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, width=device-width" />

	<meta name="format-detection" content="telephone=no" />

	{{HTML::style('/css/bootstrap.min.css')}}
	{{HTML::style('/css/bootstrap-theme.min.css')}}
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	{{HTML::style('/css/jquery.pnotify.default.css')}}
    {{HTML::style('/css/app.css')}}



    {{HTML::script('/js/jquery.min.js')}}
    {{HTML::script('/js/jquery.pnotify.min.js')}}
	{{HTML::script('/js/bootstrap.min.js')}}
	{{HTML::script('/js/bootbox.min.js')}}
	
	
	@if (Session::get('error'))
		<script type="text/javascript">
			$(document).ready(function () {
				$.pnotify({
			    	text: '{{Session::get('error');}}',
			    	type: 'error',
			    	history: false
			    });
			});
		</script>
	@endif

	@if (Session::get('success'))
		<script type="text/javascript">
			$(document).ready(function () {
				$('<div>')
					.attr( 'id', 'alertmsg1' )
				    .html(
				     '<h1>Success</h1>' +
				     '<p>' +
				     '{{Session::get('success');}}' +
				     '</p>')
				  	.addClass('alert alert-success flyover flyover-bottom')
				  	.appendTo( $('body') );
				  	$('#alertmsg1').addClass('in');

			         setTimeout(function() {
			            $('#alertmsg1').removeClass('in');
			         }, 3200);
							
			});
		</script>
	@endif
		

		<!-- <script type="text/javascript">
			$(document).ready(function () {
				$.pnotify({
			    	text: '{{Session::get('success');}}',
			    	type: 'success',
			    	history: false
			    });
			});
		</script> -->
	
	
	<script type="text/javascript">	
	$(document).ready(function () {
				
		$('.nav-select-box').on('change',function(){
			window.location = $(this).find('option:selected').val();
		});
	
	});
	</script>

	<script type="text/javascript"> 
        $(function(){
            $("#select-btn, #action-btn, #check-box").hide();
            $(".sub-label").on("click", function(){
            $("#select-btn, #action-btn, #check-box").toggle();
            });
        });
     </script>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
	</script>
