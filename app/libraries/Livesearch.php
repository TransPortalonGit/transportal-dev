<?php

define('DB_USER', 'root');
define('DB_PASSWORD', 'kodin');
define('DB_SERVER', 'localhost');
define('DB_NAME', 'transportal');

if (!$db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME)) 
{
	die($db->connect_errno.' - '.$db->connect_error);
}

$arr = array();

if (!empty($_POST['keywords'])) 
{
	$keywords = $db->real_escape_string($_POST['keywords']);
	$sql = "SELECT ID, username FROM users WHERE username LIKE '%".$keywords."%'";
	$result = $db->query($sql) or die($mysqli->error);
	if ($result->num_rows > 0) 
	{
		while ($obj = $result->fetch_object()) 
		{
			$arr[] = array('id' => $obj->ID, 'username' => $obj->username);
		}
	}
}

echo json_encode($arr);

?>