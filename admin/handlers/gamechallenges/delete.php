<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$Id = "";
$Challenge = "";
$Game = "";

if (isset($_POST["Id"])) {
	$Id = $_POST["Id"];
}

if (isset($_POST["ChallengeId"])) {
	$Challenge = $_POST["ChallengeId"];
}

if (isset($_POST["GameId"])) {
	$Game = $_POST["GameId"];
}

print_r ($_POST);

global $dbserver,$db,$dbuser,$dbpassword;
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
	mysql_select_db($db, $conn);
	$sql = "delete from GameChallenges where GameChallengeId = " . mysql_real_escape_string($Id) . " and ChallengeId = " . mysql_real_escape_string($Challenge) . " and GameId = " . mysql_real_escape_string($Game);
	mysql_query($sql);
}
mysql_close ($conn);
exit();
?>