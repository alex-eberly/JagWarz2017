<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php

//setup variables
$TeamId = "";
$GameId = "";
$UserId = "";
$Description = "";

//pull in variables from form/post
if (isset($_POST["Description"])) 
	$Description = $_POST["Description"];
if (isset($_POST["GameId"])) 
	$GameId = $_POST["GameId"];
if (isset($_POST["UserId"])) 
	$UserId = $_POST["UserId"];
/**if (isset($_POST["TeamId"])) 
	$TeamId = $_POST["TeamId"];**/


$TeamFactory = newTeamFactory();
$newRecord = true;
if ($TeamId != "" && $TeamId > 0)
{
    $Team = $TeamFactory->GetOne($TeamId);
    $newRecord = false;
}
else 
{
    $Team = new Team();
	$newRecord = true;
}
$Team->GameId = $GameId;
$Team->Description = $Description;
$Team->UserId = $UserId;

if ($Team->TeamId > 0) 
{
    $TeamFactory->Update($Team);        
}
else
{
    $TeamFactory->Insert($Team);
}

echo $Team->TeamId;
exit();
?>