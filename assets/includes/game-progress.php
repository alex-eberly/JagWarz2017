<div class="col-md-12">
	<div class="bounding-box">
		<div class="bounding-box-inner" style="padding:10px;">
			<h1>GAME PROGRESS</h1>
			<div id="game-progress">
			<?php
			$ProgressFactory = new ProgressFactory();
			//Replacement code we used for integration, didn't fully work
			//$ProgressArray = $ProgressFactory->GetAll(" where GameChallengeId = " . escapeString($_GET["GameChallengeId"]) . " order by DateCreated desc limit 10 "); //code for integration
			$ProgressArray = $ProgressFactory->GetAll(" where GameId = " . escapeString($_GET["GameId"]) . " order by DateCreated desc limit 10 ");
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
			</div>
		</div> <!-- /bounding-box-inner -->
	</div> <!-- /bounding-box -->
</div>
<script type="text/javascript">
$(document).ready(function() {
	setTimeout('checkForGameScoreUpdates()', <?php echo $ajaxRefreshInSeconds * 1000; ?>);
	setTimeout('checkForGameProgressUpdates()', <?php echo $ajaxRefreshInSeconds * 1000; ?>);
});
function checkForGameScoreUpdates() {
	$.post('<?php echo $fullUrl; ?>handlers/refresh-game-score.php', { GameChallengeId: <?php echo $_GET["GameChallengeId"]; ?> }, function (output) {
		$('#game-score').html(output);
	});
	setTimeout('checkForGameScoreUpdates()', <?php echo $ajaxRefreshInSeconds * 1000; ?>);
}
function checkForGameProgressUpdates() {
	$.post('<?php echo $fullUrl; ?>handlers/refresh-game-progress.php', { GameChallengeId: <?php echo $_GET["GameChallengeId"]; ?> }, function (output) {
		$('#game-progress').html(output);
	});
	setTimeout('checkForGameProgressUpdates()', <?php echo $ajaxRefreshInSeconds * 1000; ?>);
}
</script>