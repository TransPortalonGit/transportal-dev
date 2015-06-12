<html>
<head>
    <title></title>
</head>
<body color="#000">

<div style="background-color: #34a26a">
    <img src="http://abload.de/img/transportal-logoejjvj.png" alt="" style="margin-top: 10px"/></div>
<div style="color: #000000">
    <p>The User <strong>{{{ $contactUser }}}</strong> showed an interest in your listing:</p>
    <strong style="margin-left: 55px"><a style="color: #34a26a;" href="{{ route('fabboard.listings.show', $listing->id ) }}"> {{{ $listing->title }}}</a></strong>
    <ul style="list-style: none; color: #000">
        <li style="width: 120px; float: left">Listing Type:</li> <li>{{ $listing->getType() }} </li>
        <li style="width: 120px; float: left">Type of Service:</li> <li>{{ $listing->getTypeOfService() }}</li>
        <li style="width: 120px; float: left">Ends in:</li>  <li>{{ $listing->getTimeLeft() }} <!-- getEndeaat() --></li>
    </ul>

    <p><strong>Hello {{{ $listing->user->fullname() }}},</strong></p>
    {{ nl2br($content) }}

    <p><strong>{{{ $contactUser }}}</strong></p>

    <h3 style="color: #34a26a; margin-top: 20px">Reply: {{ $email }}</h3>

</div>
<hr/>
<p>
    Copyright © 2014<br>
    TransPortal Team of Bremen University FabLab
</p>
</body>
</html>