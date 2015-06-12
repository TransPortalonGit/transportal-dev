@extends('layouts.master') 
<html>
	<head>
		<style>
		#qrplaceholder{
			height: 250px;
			width: 250px;
			margin-left: auto;
			margin-right: auto;
			margin-top: 20px;
			color: #34a26a;
			text-align: center;
			font-family: Calibri;
			font-size: 22px;
			font-weight: bold;
			border: 1px dashed #666;
			overflow:hidden;
		}
		
		#formholder{
			width: 250px;
			margin-left: auto;
			margin-right: auto;
			margin-top: 20px;
		}
		
		select {
			width: 250px;
			height: 40px;
			margin-left: auto;
			margin-right: auto;
		}
		
		#submitbutton {
			width: 250px;
			height: 40px;
			margin-left: auto;
			margin-right: auto;
			margin-top: 20px;
			font-family: Calibri;
			font-size: 22px;
			font-weight: bold;
		}
		
		
		</style
	</head>
<body>



<div id="qrplaceholder">
@if($postUserID == null)
<br><br>Um einen QR-Code zu erhalten, wähle dein gewünschtes Gerät und drücke auf 'Generieren'.
@else
<?php
	function encrypt($pure_string, $encryption_key) { 
     $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB); 
	 $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
	 $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, $pure_string, MCRYPT_MODE_ECB, $iv); 
	 return base64_encode($encrypted_string); 
   } 
	 
   /** * Returns decrypted original string */ 
   function decrypt($encrypted_string, $encryption_key) { 
     $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB); 
	 $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
	 $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, base64_decode($encrypted_string), MCRYPT_MODE_ECB, $iv); 
	 return ($decrypted_string); 
    }
	$text = $postUserID . $postDevice;
	$key = substr(md5(rand()), 0, strlen($text));
	$encrypted = encrypt($text, $key);
	$decrypted = decrypt($encrypted, $key);
/** * Returns an encrypted & utf8-encoded */
?>
<img src="https://chart.googleapis.com/chart?cht=qr&chs=248x248&choe=UTF-8&chl=<?php echo $encrypted; ?>"/>
{{ DB::insert('insert into qrhash (hash, user_id) values (?, ?)', array($encrypted, $postUserID));}}
@endif
</div>

<div id="formholder">
{{ Form::open(['url' => 'seclab']) }}
    {{ Form::select('device', $permArray); }}
	{{ Form::hidden('userid', $currentuser->id); }}
	{{ Form::submit('Generieren', array('id' => 'submitbutton')); }}
{{ Form::close() }}

</div>
@section('content')
@stop

</body>
</html>