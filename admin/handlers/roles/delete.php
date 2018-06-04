
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
//$Active = 0;
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}


global $dbserver,$db,$dbuser,$dbpassword;
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);


if ($conn) {
	mysql_select_db($db, $conn);
	$sql = "delete from Role where UserRoleId = " . mysql_real_escape_string($Id);
	mysql_query($sql);
}
mysql_close ($conn);
exit();


?>
