<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php

//setup variables
$UserGamesId =""; 
$GameId = "";
$UserId = "";
//$RoleId = "";

//pull in variables from form/post
if (isset($_POST["UserGamesId"])) 
	$UserGamesId = $_POST["UserGamesId"];
if (isset($_POST["GameId"])) 
	$GameId = $_POST["GameId"];
if (isset($_POST["UserId"])) 
	$UserId = $_POST["UserId"];
/*if (isset($_POST["RoleId"])) 
	$RoleId = $_POST["RoleId"];*/


$UserGameFactory = new UserGameFactory();
$newRecord = true;
if ($UserGamesId != "" && $UserGamesId > 0)
{
    $UserGame = $UserGameFactory->GetOne($UserGamesId);
    $newRecord = false;
}
else 
{
    $UserGame = new UserGame();
	$newRecord = true;
}

$UserGame->UserGamesId = $UserGamesId;
$UserGame->GameId = $GameId;
$UserGame->UserId = $UserId;
//$UserGame->RoleId = $RoleId;


if ($UserGame->UserGamesId > 0) 
{
    $UserGameFactory->Update($UserGame);        
}
else
{
    $UserGameFactory->Insert($UserGame);
}

echo $UserGame->UserGamesId;
exit();
?>