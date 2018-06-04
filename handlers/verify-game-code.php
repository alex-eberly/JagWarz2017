<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$gameCode = "";
if (isset($_POST["gameCode"])) 
{
	$gameCode = $_POST["gameCode"];
}
//check game code availability
$timestamp = time();
$GameFactory = new GameFactory();
$GameArray = $GameFactory->GetAll(" where Code = '" . escapeString($gameCode) . "' and Active = 1 ");
if (count($GameArray) > 0)
{
    exit();
}
else
{
    echo "<span class=\"red-text message\">Invalid code!</span>";
}
?>