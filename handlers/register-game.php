<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php 
$UserId = "";
$GameId = "";
$GameCode = "";
if (isset($_POST["GameCode"])) 
{
	$GameCode = $_POST["GameCode"];
}
if (isset($_POST["GameId"])) 
{
	$GameId = $_POST["GameId"];
}
if (isset($_POST["UserId"])) 
{
	$UserId = $_POST["UserId"];
}
$UserGameFactory = new UserGameFactory();
$timestamp = time();
//check game availability
$GameFactory = new GameFactory();
$CodeValid = false;
$GameTitle = "";
$Games = $GameFactory->GetAll(" where GameId = '" . escapeString($GameId) . "'");
if (count($Games) > 0) 
{
	foreach ($Games as $Game)
	{
		if ($Game->Code == $GameCode)
		{
			$CodeValid = true;
			$GameTitle = $Game->Title;
		}
	}
}
else
{
	echo "<div class=\"alert alert-danger\">Incorrect code typed!</div>";
    exit();
}
if ($CodeValid)
{
	$UserGameFactory = new UserGameFactory();
	$UserGame = new UserGame; 
	$UserGame->UserId = $UserId;
	$UserGame->GameId = $GameId;
	$UserGameFactory->Insert($UserGame);
	//save progress
	$ProgressFactory = new ProgressFactory();
	$Progress = new Progress();
	$Progress->UserId = $UserId;
	$Progress->Username = $_SESSION["Username"];
	$Progress->Status = " just registered for " . $GameTitle;
	$Progress->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
	$Progress->GameId = $GameId;
	//$Progress->ChallengeId = $ChallengeId;
	$ProgressFactory->Insert($Progress);
	echo "<div class=\"alert alert-success\">You are now registered for this game! Enjoy!</div>";
}
else
{
	echo "<div class=\"alert alert-danger\">Incorrect code typed!</div>";
}
?>