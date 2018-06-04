<div class="col-md-12">
	<div class="bounding-box">
		<div class="bounding-box-inner" style="padding:10px;">
			<h1>TEAM SCORE</h1>
			<div id="game-score">
			<?php
			$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
			if ($conn)
			{
				mysql_select_db($db, $conn);
				//Replacement code we used for integration, didn't fully work
				//$sql = "select u.*, (select sum((select c.PointValue from Challenge as c, GameChallenges as gc where c.ChallengeId = gc.ChallengeId and uc.GameChallengeId = gc.GameChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameChallengeId = " . escapeString($_GET["GameChallengeId"]) . " and uc.IsCorrect = 1) as Score from User u where u.IsActive = 1 order by (select sum((select c.PointValue from Challenge as c, GameChallenges as gc where c.ChallengeId = gc.ChallengeId and uc.GameChallengeId = gc.GameChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameChallengeId = " . escapeString($_GET["GameChallengeId"]) . " and uc.IsCorrect = 1) desc"; //code for integration
				$sql = "select sum(c.PointValue) as RedScore from GameChallenges gc INNER JOIN Challenge c ON gc.ChallengeId = c.ChallengeId INNER JOIN Game ON gc.GameId = Game.GameId WHERE Game.GameId = " . escapeString($_GET["GameId"]) . " AND gc.IsCorrect = 1";
				$result=mysql_query($sql);
				//if (mysql_num_rows($result) > 0)
				//{
					echo "<ul class=\"progress-list\">";
					$i = 0;
					$lastScore = 0;
					while($row = mysql_fetch_array($result))
					{
						if ($row["RedScore"] != "")
						{
							if ($lastScore != $row["RedScore"])
							{
								$i++;
							}
							$lastScore = $row["RedScore"];
							  if ($row["RedScore"] != "") {
							    $RedScore = $row["RedScore"]; }
							  elseif ($row["RedScore"] = "")
							    { $RedScore = 0; }
							echo "Red Team: "; 
							echo $RedScore;
						}
						else
						{$RedScore = 0;
						echo "Red Team: ";
						echo $RedScore;}
					}
					echo "</ul><hr>";

			}

			mysql_close ($conn);
			$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
			if ($conn)
			{
				mysql_select_db($db, $conn);
				$sql = "select sum(c.PointValue) as BlueScore from GameChallenges gc INNER JOIN Challenge c ON gc.ChallengeId = c.ChallengeId INNER JOIN Game ON gc.GameId = Game.GameId WHERE Game.GameId = " . escapeString($_GET["GameId"]);
				  $result=mysql_query($sql);
					echo "<ul class=\"progress-list\">";
					$i = 0;
					$lastScore = 0;
					while($row = mysql_fetch_array($result))
					{
						if ($row["BlueScore"] != "")
						{
							if ($lastScore != $row["BlueScore"])
							{
								$i++;
							}
							$lastScore = $row["BlueScore"];
							echo "Blue Team: "; 
							$BlueScore = $row["BlueScore"] - $RedScore;
							echo $BlueScore;
							echo "</ul>";
						}
						else
						{
							$BlueScore = 0;
							echo "Blue Team: ";
							echo $BlueScore;
						}
					}
			}
		
			mysql_close ($conn);
				    
			?>
			</div>
		</div> <!-- /bounding-box-inner -->
	</div> <!-- /bounding-box -->
</div>