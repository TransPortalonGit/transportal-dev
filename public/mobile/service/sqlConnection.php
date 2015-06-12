<?php
$verbindung = mysql_connect ("localhost",
"root", "root")
or die ("keine Verbindung möglich.
 Benutzername oder Passwort sind falsch");

mysql_select_db("db380349546")
or die ("Die Datenbank existiert nicht.");
