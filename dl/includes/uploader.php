<?php
include_once 'psl-config.php';
include_once 'server-info.php';
include_once 'db-connect.php';
include_once 'functions.php';
 
sec_session_start();

$user = htmlentities($_SESSION['username']);
$filepath = "C:\\GitHub\\php-filesharing\\dl\\upload\\";							//Change your path to 'upload' folder
$userpath = $filepath. $user. "\\";
$userfilepath = $filepath. $user. "\\". $_FILES['file']['name'];

if( $_FILES['file']['name'] != "" )
{
	if (!file_exists($filepath. htmlentities($_SESSION['username']). '\\')) {
    mkdir($filepath. htmlentities($_SESSION['username']). '\\', 0777, true);
}
	rename( $_FILES['file']['tmp_name'], $userfilepath ) or 
           die( "Could not copy file!");		

$sql = "INSERT INTO `files`(
	`userid`, 
	`filename`, 
	`filesize`, 
	`filetype`, 
	`filepath`
	) 
	VALUES 
	(\"". get_user_id($user). "\",\"". 
	$_FILES['file']['name']. "\",\"". 
	$_FILES['file']['size']. "\",\"". 
	$_FILES['file']['type']. "\",\"". 
	$serveradress. $user. "/". $_FILES['file']['name']. 
	"\")";
	
	mysql_connect(HOST, USER, PASSWORD)
	or die("Zapytanie niepoprawne");
	
	$sqlinit = "USE secure_login";
	mysql_query($sqlinit);					//Bugfix for "No Database Selected"
	
	$query = mysql_query($sql)
	or die(mysql_error());
}
else
{
    die("No file specified!");
}
?>
<html>
<head>
<title>Uploading Complete</title>
</head>
<body>
<h2>Uploaded File Info:</h2>
<ul>
<li>Sent file: <?php echo $_FILES['file']['name'];  ?>
<li>File size: <?php echo $_FILES['file']['size'];  ?> bytes
<li>File type: <?php echo $_FILES['file']['type'];  ?>
<li>File path: <?php echo $serveradress. $user. "/". $_FILES['file']['name']; ?>
</ul>
</body>
</html>