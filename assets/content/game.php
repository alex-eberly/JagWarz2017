<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
				<?php //The code below is for opening up a chosen game and gathering all the information/challenges
				$GameFactory = new GameFactory();
				$GamesArray = $GameFactory->GetAll(" where Active = 1 and GameId = " . escapeString($_GET["GameId"]) . " ");
				foreach ($GamesArray as $Game)
				{
					$Game->GameType;
					
					if($Game->GameType == "CTF") //all the code within this else if statement is what will appear above the jaguar key for the CTF page
					{
						$sideScore = 'assets/includes/game-score.php';
						echo "<h1>" . $Game->Title . "</h1>";//prints the game title
						//check if user is registered for this game
						$UserGameFactory = new UserGameFactory();
						$UserGameArray = $UserGameFactory->GetAll(" where UserId = " . $_SESSION["UserId"] . " and GameId = " . escapeString($_GET["GameId"]) . " ");
						if (count($UserGameArray) > 0)
						{
							$timestamp = time();
							if($timestamp >= strtotime($Game->OpenDate) && $timestamp <= strtotime($Game->CloseDate))
							{
								echo "<p class=\"list-group-item-text center\">" . $Game->Description . "</p>";//prints the description of the game below the title
								//now get the challenges
								/*$ChallengeFactory = new ChallengeFactory();
								$ChallengeArray = $ChallengeFactory->GetAll(" where GameId = " . escapeString($_GET["GameId"]) . " order by PointValue ");*/
								$GameChallengeFactory = new GameChallengeFactory();
								$GameChallengeArray = $GameChallengeFactory->GetAll(" where Challenge.ChallengeId = GameChallenges.ChallengeId and GameId = " . escapeString($_GET["GameId"]) . " order by PointValue ");
								echo "<ul class=\"challenge-list\">";//list of challenges given to the specific game, doesn't always show challenges
								foreach ($GameChallengeArray as $Challenge)
								{
									echo "<li class=\"challenge-item\">";
									$status = 'unavailable';//above prints each individual challenge item then it becomes represented by the black jaguar head on this line before being updated below
									
									$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
									if ($conn)
									{
										mysql_select_db($db, $conn);//below is the code for which jaguar head color appears in each given situation
										$sql = "select (case 
			when ((SELECT count(*) FROM `UserChallengeSubmission` uc WHERE uc.ChallengeId = " . $Challenge->ChallengeId . " and uc.UserId = " . $_SESSION["UserId"] . " and uc.GameId = " . escapeString($_GET["GameId"]) . " and uc.IsCorrect = 1) > 0) then 'successfully-answered'
			when ((SELECT count(*) FROM `UserChallengeSubmission` uc WHERE uc.ChallengeId = " . $Challenge->ChallengeId . " and uc.UserId = " . $_SESSION["UserId"] . " and uc.GameId = " . escapeString($_GET["GameId"]) . " and uc.IsCorrect = 0) > 0) then 'unsuccessfully-answered'
			when ((SELECT c.IsOpen FROM `Challenge` c WHERE c.ChallengeId = " . $Challenge->ChallengeId . ") = 1) then 'available'
			else
			'unavailable'
			end) as status";//the four statuses can be found in html/assets/css/styles.css starting around line 153 (8-15-2016)
										$result=mysql_query($sql);
										while($row = mysql_fetch_array($result))
										{
											$status = $row['status'];
											
										}
									}
									mysql_close ($conn);
									if ($status == "unavailable")
									{
										echo "<a href=\"javascript:void(0);\" class=\"$status\" title=\"" . $Challenge->Title . "\"><span>" . $Challenge->PointValue . "</span></a>";
									}
									else
									{
										echo "<a href=\"" . $fullUrl . "challenge.php?GameId=" . $Game->GameId . "&ChallengeId=" . $Challenge->ChallengeId . "\" class=\"$status\" title=\"" . $Challenge->Title . "\"><span>" . $Challenge->PointValue . "</span></a>";
									}
									echo "</li>";
								}
								echo "</ul>";
							}
							else 
							{
								echo "<p class=\"list-group-item-text center\">" . $Game->ClosedDescription . "</p>";
							}
						}
						else
						{
								?>
								<div id="frmMain">
									<span class="form-label">Enter Game Code: *</span> <span id="game-code-validation"></span>
									<div class="form-group">
										<input type="text" id="txtGameCode" class="form-control required" placeholder="Enter Game Code">
									</div>
									<div id="lblResponse" style="margin-top:10px;"></div>
									<button class="btn btn-lg btn-orange btn-block default-button" onclick="Register()" type="button">REGISTER</button>
									<a class="btn btn-lg btn-orange btn-block" href="<?php echo $fullUrl . "dashboard.php"; ?>">BACK TO DASHBOARD</a>
								</div>
								<?php //above is opened up only if you are entering a given game that has not been registered before
						}
					}
					else if($Game->GameType == "RvB") //all the code within this else if statement is what will appear above the jaguar key for the RvB page
					{ 
						$sideContent = 'assets/includes/game-progress.php';
						$sideScore = 'assets/includes/team-score.php';
						echo "<h1>" . $Game->Title . "</h1>";//prints the game title
						//check if user is registered for this game
						$UserGameFactory = new UserGameFactory();
						$UserGameArray = $UserGameFactory->GetAll(" where UserId = " . $_SESSION["UserId"] . " and GameId = " . escapeString($_GET["GameId"]) . " ");
						if (count($UserGameArray) > 0)//" where UserId = " . $_SESSION["UserId"] . " and GameId = " " where GameId = " . escapeString($_GET["GameId"]) . " "
						{
							$timestamp = time();
							if($timestamp >= strtotime($Game->OpenDate) && $timestamp <= strtotime($Game->CloseDate))
							{
								echo "<p class=\"list-group-item-text center\">" . $Game->Description . "</p>";//prints the description of the game below the title
								//now get the challenges
								/*$ChallengeFactory = new ChallengeFactory();
								$ChallengeArray = $ChallengeFactory->GetAll(" where GameId = " . escapeString($_GET["GameId"]) . " order by PointValue ");*/
								$GameChallengeFactory = new GameChallengeFactory();
								$GameChallengeArray = $GameChallengeFactory->GetAll(" where Challenge.ChallengeId = GameChallenges.ChallengeId and GameId = " . escapeString($_GET["GameId"]) . " order by PointValue ");
								echo "<ul class=\"challenge-list\">";//list of challenges given to the specific game, doesn't always show challenges
								foreach ($GameChallengeArray as $Challenge)
								{
									echo "<li class=\"challenge-item\">";
									$status = 'unavailable';//above prints each individual challenge item then it becomes represented by the black jaguar head on this line before being updated below
									//return status
									$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
									if ($conn)
									{
										mysql_select_db($db, $conn);//below is the code for which jaguar head color appears in each given situation
										$sql = "select (case 
			when ((SELECT count(*) FROM `GameChallenges` gc WHERE gc.ChallengeId = " . $Challenge->ChallengeId . " and gc.GameId = " . escapeString($_GET["GameId"]) . " and gc.IsCorrect = 1) > 0) then 'attacker'
			when ((SELECT count(*) FROM `GameChallenges` gc WHERE gc.ChallengeId = " . $Challenge->ChallengeId . " and gc.GameId = " . escapeString($_GET["GameId"]) . " and gc.IsCorrect = 0) > 0) then 'defender-head'
			when ((SELECT c.IsOpen FROM `Challenge` c WHERE c.ChallengeId = " . $Challenge->ChallengeId . ") = 1) then 'defender-head'
			else
			'unavailable'
			end) as status";//keep in mind that "attacker" = red jaguar head and "defender-head" = blue jaguar head //. " and uc.UserId = " . $_SESSION["UserId"] . " and ..."
										$result=mysql_query($sql);
										while($row = mysql_fetch_array($result))
										{
											$status = $row['status'];
										}
									}
									mysql_close ($conn);
									if ($status == "unavailable")
									{
										echo "<a href=\"javascript:void(0);\" class=\"$status\" title=\"" . $Challenge->Title . "\"><span>" . $Challenge->PointValue . "</span></a>";
									}
									else
									{
										echo "<a href=\"" . $fullUrl . "challenge.php?GameId=" . $Game->GameId . "&ChallengeId=" . $Challenge->ChallengeId . "\" class=\"$status\" title=\"" . $Challenge->Title . "\"><span>" . $Challenge->PointValue . "</span></a>";
									}
									echo "</li>";
								}
								echo "</ul>";
							}
							else 
							{
								echo "<p class=\"list-group-item-text center\">" . $Game->ClosedDescription . "</p>";
			$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
			if ($conn)
			{
				mysql_select_db($db, $conn);
				//Replacement code we used for integration, didn't fully work
				//$sql = "select u.*, (select sum((select c.PointValue from Challenge as c, GameChallenges as gc where c.ChallengeId = gc.ChallengeId and uc.GameChallengeId = gc.GameChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameChallengeId = " . escapeString($_GET["GameChallengeId"]) . " and uc.IsCorrect = 1) as Score from User u where u.IsActive = 1 order by (select sum((select c.PointValue from Challenge as c, GameChallenges as gc where c.ChallengeId = gc.ChallengeId and uc.GameChallengeId = gc.GameChallengeId)) as Score from UserChallengeSubmission uc where uc.UserId = u.UserId and uc.GameChallengeId = " . escapeString($_GET["GameChallengeId"]) . " and uc.IsCorrect = 1) desc"; //code for integration
				$sql = "select sum(c.PointValue) as RedScore from GameChallenges gc INNER JOIN Challenge c ON gc.ChallengeId = c.ChallengeId AND c.IsComplete = 1 INNER JOIN Game ON gc.GameId = Game.GameId WHERE Game.GameId = " . escapeString($_GET["GameId"]);
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
							//echo "Red Team: "; 
							//echo $RedScore;
						}
						else
						{$RedScore = 0;
						//echo "Red Team: ";
						//echo $RedScore;
						}
					}
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
							//echo "Blue Team: "; 
							$BlueScore = $row["BlueScore"] - $RedScore;
							//echo $BlueScore;
							echo "</ul>";
						}
						else
						{
						$BlueScore = 0;
						}
					}
			}
		
			mysql_close ($conn);
			if ($RedScore > $BlueScore)
				{
				echo "Red Team wins!!!";
				echo '<canvas id="canvas"></canvas>';
				}
			elseif ($BlueScore > $RedScore)
				{
				echo "Blue Team wins!!!";
				echo '<canvas id="canvas"></canvas>';

				}
			elseif ($BlueScore == $RedScore)
				{
				echo "It's a tie!";
				}
					
					}
						}
						else
						{
								?>
								<div id="frmMain">
									<span class="form-label">Enter Game Code: *</span> <span id="game-code-validation"></span>
									<div class="form-group">
										<input type="text" id="txtGameCode" class="form-control required" placeholder="Enter Game Code">
									</div>
									<div id="lblResponse" style="margin-top:10px;"></div>
									<button class="btn btn-lg btn-orange btn-block default-button" onclick="Register()" type="button">REGISTER</button>
									<a class="btn btn-lg btn-orange btn-block" href="<?php echo $fullUrl . "dashboard.php"; ?>">BACK TO DASHBOARD</a>
								</div>
								<?php //above is opened up only if you are entering a given game that has not been registered before
						}
					}
					else
					{
						exit();
					}
				}

				?>
			</div> <!-- /bounding-box-inner -->
		</div> <!-- /bounding-box -->
	</div> <!-- /col-md-6 -->
</div> <!-- /row -->
<div class="row">
	<div class="col-md-12">
		<div class="bounding-box">
			<div class="bounding-box-inner">
			<?php 
			$GameFactory = new GameFactory();
			$GamesArray = $GameFactory->GetAll(" where Active = 1 and GameId = " . escapeString($_GET["GameId"]) . " ");
			foreach ($GamesArray as $Game)
			{
				$Game->GameType;//I do not know if having this is necessary, but I added it initially to guarantee that GameType would be recognized
				if($Game->GameType == "CTF")//open the Capture the Flag jaguar head key
				{
			?>
				<h1>LEGEND</h1>
				<ul class="challenge-list">
					<li class="challenge-item">
						<a title="Gray indicates the challenge is not available to answer yet" class="unavailable" href="javascript:void(0);"><span>Unavailable</span></a>
					</li>
					<li class="challenge-item">
						<a title="Yellow means the challenge is available to answer" class="available" href="javascript:void(0);"><span>Available</span></a>
					</li>
					<li class="challenge-item">
						<a title="Red indicates you submitted an incorrect answer" class="unsuccessfully-answered" href="javascript:void(0);"><span>Incorrect</span></a>
					</li>
					<li class="challenge-item">
						<a title="Green indicates you have successfully completed the challenge" class="successfully-answered" href="javascript:void(0);"><span>Answered</span></a>
					</li>
				</ul>
			<?php
				}
				else if($Game->GameType == "RvB")//open the Red versus Blue jaguar head key
				{
			?>
				<h1>LEGEND</h1>
				<ul class="challenge-list">
					<li class="challenge-item">
						<a title="Grey indicates the challenge is not available to answer yet" class="unavailable" href="javascript:void(0);"><span>Unavailable</span></a>
					</li>
					<li class="challenge-item">
						<a title="Blue means the challenge has not been beaten by the Attackers" class="defender-head" href="javascript:void(0);"><span>Currently Safe</span></a>
					</li>
					<li class="challenge-item">
						<a title="Red means the challenge was answered by the Attackers" class="attacker" href="javascript:void(0);"><span>Hacked</span></a>
					</li>
				</ul>
			<?php
				}
				else
				{
					exit();//if neither game types are recognized, close the game to avoid errors
				}
			}
			?>
			</div> <!-- /bounding-box-inner -->
		</div> <!-- /bounding-box -->
	</div> <!-- /col-md-6 -->
</div> <!-- /row -->

<!--Notes for Red vs Blue code, some of this work may already be done and can instead help you explain the intention of the code changes-->
	<!--The actual code should be written further up, within the first box-->
	<!--Have some code to find out which GameType the game is, then have the jaguar heads appear respectively-->
	<!--Make this code similar, but jaguar heads are blue (available), red (answered correctly), or black (unavailable)-->
	<!--Game Score should say Team Score, but the team aspect will be implemented after-->


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
	function Register() {
		$.post('handlers/register-game.php', { UserId: <?php echo $_SESSION["UserId"]; ?>, GameId: <?php echo $_GET["GameId"]; ?>, GameCode: $('#txtGameCode').val()  }, function(output) {
			$('#lblResponse').html(output).show();
			setTimeout('location.reload()', 3000);
		});
	}
</script>
<!-- Confetti animation below -->
<script>
(function () {
    // globals
    var canvas;
    var ctx;
    var W;
    var H;
    var mp = 150; //max particles
    var particles = [];
    var angle = 0;
    var tiltAngle = 0;
    var confettiActive = true;
    var animationComplete = true;
    var deactivationTimerHandler;
    var reactivationTimerHandler;
    var animationHandler;

    // objects

    var particleColors = {
        colorOptions: ["DodgerBlue", "OliveDrab", "Gold", "pink", "SlateBlue", "lightblue", "Violet", "PaleGreen", "SteelBlue", "SandyBrown", "Chocolate", "Crimson"],
        colorIndex: 0,
        colorIncrementer: 0,
        colorThreshold: 10,
        getColor: function () {
            if (this.colorIncrementer >= 10) {
                this.colorIncrementer = 0;
                this.colorIndex++;
                if (this.colorIndex >= this.colorOptions.length) {
                    this.colorIndex = 0;
                }
            }
            this.colorIncrementer++;
            return this.colorOptions[this.colorIndex];
        }
    }

    function confettiParticle(color) {
        this.x = Math.random() * W; // x-coordinate
        this.y = (Math.random() * H) - H; //y-coordinate
        this.r = RandomFromTo(10, 30); //radius;
        this.d = (Math.random() * mp) + 10; //density;
        this.color = color;
        this.tilt = Math.floor(Math.random() * 10) - 10;
        this.tiltAngleIncremental = (Math.random() * 0.07) + .05;
        this.tiltAngle = 0;

        this.draw = function () {
            ctx.beginPath();
            ctx.lineWidth = this.r / 2;
            ctx.strokeStyle = this.color;
            ctx.moveTo(this.x + this.tilt + (this.r / 4), this.y);
            ctx.lineTo(this.x + this.tilt, this.y + this.tilt + (this.r / 4));
            return ctx.stroke();
        }
    }

    $(document).ready(function () {
        SetGlobals();
        InitializeButton();
        InitializeConfetti();

        $(window).resize(function () {
            W = window.innerWidth;
            H = window.innerHeight;
            canvas.width = W;
            canvas.height = H;
        });

    });

    function InitializeButton() {
        $('#stopButton').click(DeactivateConfetti);
        $('#startButton').click(RestartConfetti);
    }

    function SetGlobals() {
        canvas = document.getElementById("canvas");
        ctx = canvas.getContext("2d");
        W = window.innerWidth;
        H = window.innerHeight;
        canvas.width = W;
        canvas.height = H;
    }

    function InitializeConfetti() {
        particles = [];
        animationComplete = false;
        for (var i = 0; i < mp; i++) {
            var particleColor = particleColors.getColor();
            particles.push(new confettiParticle(particleColor));
        }
        StartConfetti();
    }

    function Draw() {
        ctx.clearRect(0, 0, W, H);
        var results = [];
        for (var i = 0; i < mp; i++) {
            (function (j) {
                results.push(particles[j].draw());
            })(i);
        }
        Update();

        return results;
    }

    function RandomFromTo(from, to) {
        return Math.floor(Math.random() * (to - from + 1) + from);
    }


    function Update() {
        var remainingFlakes = 0;
        var particle;
        angle += 0.01;
        tiltAngle += 0.1;

        for (var i = 0; i < mp; i++) {
            particle = particles[i];
            if (animationComplete) return;

            if (!confettiActive && particle.y < -15) {
                particle.y = H + 100;
                continue;
            }

            stepParticle(particle, i);

            if (particle.y <= H) {
                remainingFlakes++;
            }
            CheckForReposition(particle, i);
        }

        if (remainingFlakes === 0) {
            StopConfetti();
        }
    }

    function CheckForReposition(particle, index) {
        if ((particle.x > W + 20 || particle.x < -20 || particle.y > H) && confettiActive) {
            if (index % 5 > 0 || index % 2 == 0) //66.67% of the flakes
            {
                repositionParticle(particle, Math.random() * W, -10, Math.floor(Math.random() * 10) - 20);
            } else {
                if (Math.sin(angle) > 0) {
                    //Enter from the left
                    repositionParticle(particle, -20, Math.random() * H, Math.floor(Math.random() * 10) - 20);
                } else {
                    //Enter from the right
                    repositionParticle(particle, W + 20, Math.random() * H, Math.floor(Math.random() * 10) - 20);
                }
            }
        }
    }
    function stepParticle(particle, particleIndex) {
        particle.tiltAngle += particle.tiltAngleIncremental;
        particle.y += (Math.cos(angle + particle.d) + 3 + particle.r / 2) / 2;
        particle.x += Math.sin(angle);
        particle.tilt = (Math.sin(particle.tiltAngle - (particleIndex / 3))) * 15;
    }

    function repositionParticle(particle, xCoordinate, yCoordinate, tilt) {
        particle.x = xCoordinate;
        particle.y = yCoordinate;
        particle.tilt = tilt;
    }

    function StartConfetti() {
        W = window.innerWidth;
        H = window.innerHeight;
        canvas.width = W;
        canvas.height = H;
        (function animloop() {
            if (animationComplete) return null;
            animationHandler = requestAnimFrame(animloop);
            return Draw();
        })();
    }

    function ClearTimers() {
        clearTimeout(reactivationTimerHandler);
        clearTimeout(animationHandler);
    }

    function DeactivateConfetti() {
        confettiActive = false;
        ClearTimers();
    }

    function StopConfetti() {
        animationComplete = true;
        if (ctx == undefined) return;
        ctx.clearRect(0, 0, W, H);
    }

    function RestartConfetti() {
        ClearTimers();
        StopConfetti();
        reactivationTimerHandler = setTimeout(function () {
            confettiActive = true;
            animationComplete = false;
            InitializeConfetti();
        }, 100);

    }

    window.requestAnimFrame = (function () {
        return window.requestAnimationFrame || 
        window.webkitRequestAnimationFrame || 
        window.mozRequestAnimationFrame || 
        window.oRequestAnimationFrame || 
        window.msRequestAnimationFrame || 
        function (callback) {
            return window.setTimeout(callback, 1000 / 60);
        };
    })();
})();
</script>