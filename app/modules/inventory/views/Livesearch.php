<?php

$db = new mysqli('localhost','root','kodin','transportal', 8889);

if (!$db) 
{
	die($db->connect_errno.' - '.$db->connect_error);
}

$arr = array();

if (!empty($_POST['keywords'])) 
{
	$keywords = $db->mysqli_escape_string($_POST['keywords']);
	$sql = "SELECT id, username FROM users WHERE username LIKE '%".$keywords."%'";
	$result = $db->query($sql) or die($mysqli->error);
	if ($result->num_rows > 0) 
	{
		while ($obj = $result->fetch_object()) 
		{
			$arr[] = array('id' => $obj->id, 'username' => $obj->username);
		}
	}
}

echo json_encode($arr);

?>