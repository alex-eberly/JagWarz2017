<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
if (isset($_POST["Id"])) 
{
	$Id = $_POST["Id"];
}
$Filename = "";
if (isset($_POST["Filename"])) 
{
	$Filename = $_POST["Filename"];
}
global $dbserver,$db,$dbuser,$dbpassword;
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
	mysql_select_db($db, $conn);
	$path = $_SERVER['DOCUMENT_ROOT'] . "/files/" . $Filename;
	unlink($path);
	$sql = "delete from ChallengeFile where ChallengeFileId = " . mysql_real_escape_string($Id);
	mysql_query($sql);
}
mysql_close ($conn);
exit();
?>