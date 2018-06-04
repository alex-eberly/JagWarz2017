<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php

//setup variables
$GameId = ""; //ajaxSave() pulls these variables, then places the values from load.php into it
$Title = "";
$Description = "";
$ClosedDescription = "";
$OpenDate = "";
$CloseDate = "";
$Code = "";
$Active = 1;
$GameType = "";//variable added to determine RvB - CTF

//pull in variables from form/post
if (isset($_POST["Description"])) 
	$Description = $_POST["Description"];
if (isset($_POST["ClosedDescription"])) 
	$ClosedDescription = $_POST["ClosedDescription"];
if (isset($_POST["OpenDate"])) 
	$OpenDate = $_POST["OpenDate"];
if (isset($_POST["CloseDate"])) 
	$CloseDate = $_POST["CloseDate"];
if (isset($_POST["Code"])) 
	$Code = $_POST["Code"];
if (isset($_POST["GameId"])) 
	$GameId = $_POST["GameId"];
if (isset($_POST["Title"])) 
	$Title = $_POST["Title"];
if (isset($_POST["GameType"]))
	$GameType = $_POST["GameType"];
	
	
	echo "hi";
	
$GameFactory = new GameFactory();
$newRecord = true;
$timestamp = time();
if ($GameId != "" && $GameId > 0)
{
    $Game = $GameFactory->GetOne($GameId);
    $newRecord = false;
}
else 
{
    $Game = new Game();
	$newRecord = true;
}
$Game->Title = $Title;
$Game->Description = $Description;
$Game->ClosedDescription = $ClosedDescription;
$Game->OpenDate = date('Y-m-d',strtotime($OpenDate));
$Game->CloseDate = date('Y-m-d',strtotime($CloseDate));
$Game->Code = $Code;
$Game->Active = $Active;
$Game->GameType = $GameType;

if ($Game->GameId > 0) 
{
    $GameFactory->Update($Game);        
}
else
{
    $GameFactory->Insert($Game);
}
echo $Game->GameId;
exit();
?>