<html>
	<head>
		<title></title>
	</head>
	<body>
		<p>Dear {{ $user->first_name }},</p>

		<p>Welcome to TransPortal! Your account has been created!</p>

		<p>Please click on the following link to confirm your account:</p>

		<p><a href="{{ URL::to('account/activate/' . $user->id . '/' . $activationcode) }}">{{ URL::to('account/activate/' . $user->id . '/' . $activationcode) }}</a></p>

		<p>Best regards,</p>

		<p>The TransPortal Team</p>
	</body>
</html>