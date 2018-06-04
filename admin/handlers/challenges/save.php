<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php

//setup variables
$ChallengeId = "";
$Title = "";
$Description = "";
$CorrectAnswer = "";
$PointValue = "";
$IsComplete = "";
$IsOpen = "";
$Tags = "";
$GameId = "";
$FileNumber = 0;

//pull in variables from form/post
/*if (isset($_POST["GameId"])) 
	$GameId = $_POST["GameId"];*/
if (isset($_POST["Description"])) 
	$Description = $_POST["Description"];
if (isset($_POST["CorrectAnswer"])) 
	$CorrectAnswer = $_POST["CorrectAnswer"];
if (isset($_POST["PointValue"])) 
	$PointValue = $_POST["PointValue"];
if (isset($_POST["IsComplete"])) 
	$IsComplete = $_POST["IsComplete"];
if (isset($_POST["IsOpen"])) 
	$IsOpen = $_POST["IsOpen"];
if (isset($_POST["Tags"])) 
	$Tags = $_POST["Tags"];
if (isset($_POST["ChallengeId"])) 
	$ChallengeId = $_POST["ChallengeId"];
if (isset($_POST["Title"])) 
	$Title = $_POST["Title"];
if (isset($_POST["FileNumber"])) 
	$FileNumber = $_POST["FileNumber"];

$ChallengeFactory = new ChallengeFactory();
$newRecord = true;
if ($ChallengeId != "" && $ChallengeId > 0)
{
    $Challenge = $ChallengeFactory->GetOne($ChallengeId);
    $newRecord = false;
}
else 
{
    $Challenge = new Challenge();
	$newRecord = true;
}
$Challenge->Title = $Title;
/*$Challenge->GameId = $GameId;*/
$Challenge->Description = $Description;
$Challenge->CorrectAnswer = strtoupper($CorrectAnswer);
$Challenge->PointValue = $PointValue;
$Challenge->IsComplete = $IsComplete;
$Challenge->IsOpen = $IsOpen;
$Challenge->Tags = $Tags;

if ($Challenge->ChallengeId > 0) 
{
    $ChallengeFactory->Update($Challenge);        
}
else
{
    $ChallengeFactory->Insert($Challenge);
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

echo $Challenge->ChallengeId;
exit();
?>