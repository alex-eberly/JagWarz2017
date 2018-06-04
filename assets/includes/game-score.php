<div class="col-md-12">
	<div class="bounding-box">
		<div class="bounding-box-inner" style="padding:10px;">
			<h1>GAME SCORE</h1>
			<div id="game-score">
			<?php
			$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
			if ($conn)
			{
				mysql_select_db($db, $conn);
				$sql = "select u.*, (select sum((select c.PointValue from Challenge c where c.ChallengeId = uc.ChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameId = " . escapeString($_GET["GameId"]) . " and uc.IsCorrect = 1) as Score from User u where u.IsActive = 1 order by (select sum((select c.PointValue from Challenge c where c.ChallengeId = uc.ChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameId = " . escapeString($_GET["GameId"]) . " and uc.IsCorrect = 1) desc";
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
			</div>
		</div> <!-- /bounding-box-inner -->
	</div> <!-- /bounding-box -->
</div>