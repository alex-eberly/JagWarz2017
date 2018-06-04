<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$ProgressFactory = new ProgressFactory();
$ProgressArray = $ProgressFactory->GetAll(" where GameId = " . escapeString($_POST["GameId"]) . " order by DateCreated desc limit 10 ");
//Replacement code meant to be used for integration, but did not work
//$ProgressArray = $ProgressFactory->GetAll(" where GameChallengeId = " . escapeString($_POST["GameChallengeId"]) . " order by DateCreated desc limit 10 ");
if (count($ProgressArray) > 0)
{
	echo "<ul class=\"progress-list\">";
	foreach($ProgressArray as $Progress)
	{
		echo "<li class=\"progress-item\">";
		//return user
		$UserFactory = new UserFactory();
		$User = $UserFactory->GetOne($Progress->UserId);
		if ($User->UserId > 0)
		{
			echo "<span class=\"username\">" . $User->Username . "</span> ";
		}
		echo $Progress->Status;
		echo "</li>";
	}
	echo "</ul>";
}
?>