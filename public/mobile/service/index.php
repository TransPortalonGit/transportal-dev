<?php include("sqlConnection.php");?>

<?php include("UserClass.php");?>

<?php include("ProjectClass.php");?>

<?php
/*
$abfrage = "SELECT * FROM users";
$ergebnis = mysql_query($abfrage);
while($row = mysql_fetch_object($ergebnis))
   {
   echo "$row->username";
   }
*/
$action	= $_GET['action'];
$login;
$password;
$currentUser;
switch($action)
{
	case 'getUser':
		if(isset($_GET['login']) && isset($_GET['password'])) 
		{
			$currentUser	= new User();
			$login 			= $_GET['login'];
			$password 		= $_GET['password'];
			$abfrage = "SELECT * FROM users WHERE username='$login' LIMIT 1;";
			$ergebnis = mysql_query($abfrage);
			if($row = mysql_fetch_object($ergebnis))
			{
				$currentUser->login = $row->username;
				$currentUser->password = $row->password;
				$currentUser->userId = $row->id;
				$currentUser->firstname = $row->first_name;
				$currentUser->lastname = $row->last_name;
				$currentUser->email = $row->email;
				$currentUser->company = $row->company;
				session_start();
				$_SESSION['user'] = $currentUser;
			}
		}
		echo json_encode($currentUser);
	break;
	
	case 'getProjects':
		session_start();
		if (isset($_SESSION['user']))
		{
			$currentUser = $_SESSION['user'];
			$projectsList;
			$abfrage = "SELECT * FROM projects WHERE user_id = '$currentUser->userId'";
			$ergebnis = mysql_query($abfrage);
			$projectCounter = 0;
			while($row = mysql_fetch_object($ergebnis))
			{
				$currentProject = new Project();
				$currentProject->projectId = $row->id;
				$currentProject->userId = $row->user_id;
				$currentProject->title = $row->title;
				$currentProject->content = $row->content;
				$currentProject->imageUrl = $row->files;
				$currentProject->createdAt = $row->created_at;
				$currentProject->lastUpdate = $row->updated_at; 
				$projectsList[$projectCounter++] = $currentProject;
			}
			echo json_encode($projectsList);
		}
		else
		{
			echo 'getProjects: Not loged ='.$_SESSION['user'];	
		}
	break;
	
	case 'getProject':
		echo 'getProject';
	break;	
	
	default:
		echo 'Unbekanter Aktion';
	break;
}


?>
