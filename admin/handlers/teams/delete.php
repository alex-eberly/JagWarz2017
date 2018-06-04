<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
global $dbserver,$db,$dbuser,$dbpassword;
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
	mysql_select_db($db, $conn);
	$sql = "delete from Teams where TeamId = " . mysql_real_escape_string($Id);
	mysql_query($sql);
}
mysql_close ($conn);
exit();
?>