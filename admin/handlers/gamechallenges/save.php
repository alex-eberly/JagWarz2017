<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php

//setup variables
$GameChallengeId =""; //<-- 9-23-17
$ChallengeId = "";
$GameId = "";
$RowPosition = 0;

//pull in variables from form/post
if (isset($_POST["GameChallengeId"])) 
	$GameChallengeId = $_POST["GameChallengeId"]; //<-- 9-23-17
if (isset($_POST["GameId"])) 
	$GameId = $_POST["GameId"];
if (isset($_POST["ChallengeId"])) 
	$ChallengeId = $_POST["ChallengeId"];
if (isset($_POST["RowPosition"])) 
	$RowPosition = $_POST["RowPosition"];


$GameChallengeFactory = new GameChallengeFactory();
$newRecord = true;
if ($GameChallengeId != "" && $GameChallengeId > 0)
{
    $GameChallenge = $GameChallengeFactory->GetOne($GameChallengeId);
    $newRecord = false;
}
else 
{
    $GameChallenge = new GameChallenge();
	$newRecord = true;
}

$GameChallenge->GameChallengeId = $GameChallengeId;
$GameChallenge->GameId = $GameId;
$GameChallenge->ChallengeId = $ChallengeId;
$GameChallenge->RowPosition = $RowPosition;


if ($GameChallenge->GameChallengeId > 0) 
{
    $GameChallengeFactory->Update($GameChallenge);        
}
else
{
    $GameChallengeFactory->Insert($GameChallenge);
}

//now attempt to save/associate files
for ($i=1; $i<=$FileNumber; $i++)
{
	$ChallengeFileFactory = new ChallengeFileFactory();
	$ChallengeFile = new ChallengeFile();
	$ChallengeFile->ChallengeId = $Challenge->ChallengeId;
	foreach($_POST as $name => $value) {
		if ($name == ("Filename" . $i))
		{
			$ChallengeFile->Filename = $value;
			$ChallengeFile->Path = $value;
		}
	}
	$ChallengeFileFactory->Insert($ChallengeFile);
}

echo $GameChallenge->GameChallengeId;
exit();
?>