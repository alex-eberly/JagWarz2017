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
	$sql = "delete from AdminUser where AdminUserId = " . mysql_real_escape_string($Id);
	mysql_query($sql);
}
mysql_close ($conn);
exit();
/*
HARD DELETE
if (isset($_POST["TicketId"])) 
{
	$TicketId = $_POST["TicketId"];
}
global $dbserver,$db,$dbuser,$dbpassword;
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
	mysql_select_db($db, $conn);
	$sql = "delete from Ticket where TicketId = " . escapeString($TicketId);
	mysql_query($sql);
}
mysql_close ($conn);
*/
?>