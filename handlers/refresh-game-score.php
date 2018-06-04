<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
	mysql_select_db($db, $conn);
	$sql = "select u.*, (select sum((select c.PointValue from Challenge c where c.ChallengeId = uc.ChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameId = " . escapeString($_POST["GameId"]) . " and uc.IsCorrect = 1) as Score from User u where u.IsActive = 1 order by (select sum((select c.PointValue from Challenge c where c.ChallengeId = uc.ChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameId = " . escapeString($_POST["GameId"]) . " and uc.IsCorrect = 1) desc";
	//Replacement code meant to be used in integration, but did not go as planned
	//$sql = "select u.*, (select sum((select c.PointValue from Challenge as c, GameChallenges as gc where c.ChallengeId = gc.ChallengeId and uc.GameChallengeId = gc.GameChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameChallengeId = " . escapeString($_GET["GameChallengeId"]) . " and uc.IsCorrect = 1) as Score from User u where u.IsActive = 1 order by (select sum((select c.PointValue from Challenge as c, GameChallenges as gc where c.ChallengeId = gc.ChallengeId and uc.GameChallengeId = gc.GameChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameChallengeId = " . escapeString($_GET["GameChallengeId"]) . " and uc.IsCorrect = 1) desc";
	$result=mysql_query($sql);
	if (mysql_num_rows($result) > 0)
	{
		echo "<ul class=\"progress-list\">";
		$i = 0;
		$lastScore = 0;
		while($row = mysql_fetch_array($result))
		{
			if ($row["Score"] != "")
			{
				if ($lastScore != $row["Score"])
				{
					$i++;
				}
				$lastScore = $row["Score"];
				echo "<li class=\"progress-item\">";
				//return user
				echo $i . ") <span class=\"username\">" . $row["Username"] . "</span> ";
				//return score
				echo $row["Score"];
				echo "</li>";
			}
		}
		echo "</ul>";
	}
	
}
mysql_close ($conn);
?>