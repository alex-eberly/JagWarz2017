<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$code = "";
if (isset($_POST["code"])) 
{
	$code = $_POST["code"];
}
$GameFactory = new GameFactory();
$GameArray = $GameFactory->GetAll(" where Code = '" . escapeString($code) . "' and Active = 1");
if (count($GameArray) > 0)
{
    echo "<span class=\"red-text message\">Not Available!</span>";
    exit();
}
else
{
    echo "<span class=\"green-text message\">Available!</span>";
}
?>