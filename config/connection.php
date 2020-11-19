<?php
//session_start();
/* for Local Server 
$host = 'localhost';
$user = 'accommodation_user';
$pass = '?j2w}wN-Q#)C';
$db = 'accommodation_coordination'; */

 /*for Local Server*/ 
/*$host = '192.168.253.15';
$user = 'root';
$pass = 'mysql@123';
$db = 'pwdweb';*/

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'coordination';


//define('DBHR', 'db_hr');
//define('DBPMS', 'pwdpms3'); 


/* for online server */
/*$host = 'localhost';
$user = 'pwdshelltechnolo_shatabdi';
$pass = '[B$G,0zXp532';
$db = 'pwdshelltechnolo_coordination';*/


define('DBHR', 'db_hr');
define('DBPMS', 'pwdpms3');

	/*$dblink = mysql_connect($host,$user,$pass)
	or
	die("Can't connect to database");
	mysql_select_db($db, $dblink)
	or
	die("Can't find the database");
	mysql_query('SET CHARACTER SET utf8');
mysql_query("SET SESSION collation_connection ='utf8_general_ci'") or die (mysql_error());*/

/*if(isset($_SESSION["OfficeID"]) && $_SESSION["OfficeID"]!=''){
$where="OfficeID=".$_SESSION["OfficeID"];
if($_SESSION["OfficeID"]==43 || $_SESSION["OfficeID"]==44 || $_SESSION["OfficeID"]==45 || $_SESSION["OfficeID"]==46 || $_SESSION["OfficeID"]==47 ||$_SESSION["OfficeID"]==55 || $_SESSION["OfficeID"]==56 || $_SESSION["OfficeID"]==57 || $_SESSION["OfficeID"]==58) {
$whereproject=" tbl_project_division.OfficeID=".$_SESSION["OfficeID"];
} else {
$whereproject='FIND_IN_SET('.$_SESSION["OfficeID"].',DivisionID)';
}
}
else {
	$where="OfficeID!=0";
	$whereproject='!FIND_IN_SET(0,DivisionID)';
}*/


// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>