<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<?php
				//get the challenges
				//$GameChallengeFactory = new GameChallengeFactory(); //<-- Austin 9-28-17
				$ChallengeFactory = new ChallengeFactory();
				$ChallengeArray = $ChallengeFactory->GetAll(" where ChallengeId = " . escapeString($_GET["ChallengeId"]) . " ");
				foreach ($ChallengeArray as $Challenge)
				{
					echo "<h1>" . $Challenge->Title . "</h1>";
					echo "<p class=\"center\">" . $Challenge->Description . "</p>";
					//echo $_GET["GameChallengeId"]; //<--Austin 9-28-17
					$ChallengeFileFactory = new ChallengeFileFactory();
					$ChallengeFileArray = $ChallengeFileFactory->GetAll(" where ChallengeId = " . $Challenge->ChallengeId . " ");
					if (count($ChallengeFileArray) > 0)
					{
						echo "<h1>Files</h1>";
						echo "<ul class=\"file-list\" style=\"padding-bottom:10px;\">";
					}
					foreach ($ChallengeFileArray as $ChallengeFile)
					{
						echo "<li class=\"file-item\">";
						echo "<a target=\"_blank\" href=\"" . $fullUrl . "files/" . $ChallengeFile->Filename . "\" title=\"Download/View\"><span>" . $ChallengeFile->Filename . "</span></a>";
						echo "</li>";
					}
					if (count($ChallengeFileArray) > 0)
					{
						echo "</ul>";
					}
					$status = 'unavailable';
					//return status
					$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
					if ($conn)
					{
						mysql_select_db($db, $conn);
						$sql = "select (case
						when ((SELECT count(*) FROM `UserChallengeSubmission` as uc, GameChallenges as gc WHERE uc.GameChallengeId = gc.GameChallengeId AND gc.ChallengeId = " . $Challenge->ChallengeId . " and uc.UserId = " . $_SESSION["UserId"] . " and uc.IsCorrect = 1) > 0) then 'successfully-answered'
						when ((SELECT count(*) FROM `UserChallengeSubmission` as uc, GameChallenges as gc WHERE uc.GameChallengeId = gc.GameChallengeId AND gc.ChallengeId = " . $Challenge->ChallengeId . " and uc.UserId = " . $_SESSION["UserId"] . " and uc.IsCorrect = 0) > 0) then 'unsuccessfully-answered'
						when ((SELECT c.IsOpen FROM `Challenge` c WHERE c.ChallengeId = " . $Challenge->ChallengeId . ") = 1) then 'available'
						else
						'unavailable'
						end) as status";
						$result=mysql_query($sql);
						while($row = mysql_fetch_array($result))
						{
							$status = $row['status'];
							
						}
					}
					mysql_close ($conn);
					if ($status != "unavailable" && $status != "successfully-answered")
					{
						?>
						
						<h1>Answer</h1>
						<div id="lblResponseGood" style="margin-top:10px;"></div>
						<div id="frmMain">
							<div class="form-group">
								<input type="text" autofocus="" placeholder="Enter Answer" class="form-control required" id="txtAnswer">
							</div>
							<button class="btn btn-lg btn-orange btn-block default-button" type="button" id="btnSubmit" onclick="$('#btnSubmit').attr('disabled','disabled');submitAnswer();">SUBMIT</button>
							<div id="lblResponse" style="margin-top:10px;"></div>
						</div>
						<?php
					}
					else
					{
						?>
						<div class="alert alert-success">You have successfully completed this challenge!</div>
						<?php
						
					}
				}
					//The query belows makes side content global-progress if it is a CTF game
					$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
					if ($conn)
					{
						mysql_select_db($db, $conn);
						$sql="select GameType from Game where GameId = " . escapeString($_GET["GameId"]);
						$result=mysql_query($sql);
						while($row = mysql_fetch_array($result))
							{
							$GameType = $row['GameType'];
							}
						if ($GameType=='CTF'){
							$sideContent = 'assets/includes/global-progress.php';
						}						
					}
					mysql_close ($conn);
					
				?>
				<a class="btn btn-lg btn-orange btn-block" href="<?php echo $fullUrl . "game.php?GameId=" . $_GET["GameId"]; ?>">RETURN TO GAME</a>
			</div> <!-- /bounding-box-inner -->
		</div> <!-- /bounding-box -->
	</div> <!-- /col-md-6 -->
</div> <!-- /row -->
<script type="text/javascript">
	$('.challenge-list').tooltip({
	show: {
        duration: "fast"
      },
      hide: {
        duration: "fast"
      },
		position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
	});
	$(document).ready(function() {
		$('#frmMain').jvalidate({
			errorBackgroundColor: '#FFEBE8',
	        border: 'solid 2px #D4D4D4',
	        errorBorder: 'solid 2px #C00'
		});
	});
	function submitAnswer() {

		$.post('handlers/submit-answer.php', { UserId: <?php echo $_SESSION["UserId"]; ?>, GameId: <?php echo $_GET["GameId"]; ?>, ChallengeId: <?php echo $_GET["ChallengeId"]; ?>, answer: $('#txtAnswer').val()  }, function(output) {
			if (output.indexOf("success") > -1) {
				$('#frmMain').hide();
				$('#lblResponseGood').html(output).show();
			}
			else {
				$('#lblResponse').html(output).show();
				$('#btnSubmit').removeAttr('disabled');
			}
		});
	}
</script>
