<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/assets/classes/core.php"; ?>
<?php //Most of the commented out code here was used for the database integration process in my documentation
$ChallengeId = "";
$GameId = "";
$UserId = "";
$Answer = "";
$GameChallengeId = ""; //For integration of GameId and ChallengeId
//$GameChallenges = ""; //GameChallengeId from GameChallenges
//$Submission = ""; //GameChallengeId from UserChallengeSubmission
if (isset($_POST["ChallengeId"])) 
{
	$ChallengeId = $_POST["ChallengeId"];
}
if (isset($_POST["GameId"])) 
{
	$GameId = $_POST["GameId"];
}
if (isset($_POST["UserId"])) 
{
	$UserId = $_POST["UserId"];
}
if (isset($_POST["answer"])) 
{
	$Answer = strtoupper($_POST["answer"]);
}
if (isset($_POST["GameChallengeId"]))
{
	$GameChallengeId = $_POST["GameChallengeId"];
}
$GameChallengeFactory = new GameChallengeFactory();
//$GCID = $GameChallengeFactory->GetAllByGame("where GameId = " . escapeString($GameId) . " and ChallengeId = " . escapeString($ChallengeId));**/
$UserChallengeSubmissionFactory = new UserChallengeSubmissionFactory();
$UserChallengeArray = $UserChallengeSubmissionFactory->GetAll(" where UserId = " . escapeString($UserId) . " and GameId = " . escapeString($GameId) . " and IsCorrect = 1 and ChallengeId = " . escapeString($ChallengeId));

/**$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
mysql_select_db($db, $conn);
$sql = "select (case when (SELECT GC.GameChallengeId\n"
	. "FROM GameChallenges AS GC\n"
	. "WHERE GC.GameId = " . $GameId->GameId . "\n"
	. "AND GC.ChallengeId = " . $Challenge->ChallengeId . "LIMIT 0, 30 )end)as gcID";
$result=mysql_query($sql);
while($row = mysql_fetch_array($result))
	{
	$GameChallengeId = $row['gcID'];
	}
} **/

$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
mysql_select_db($db, $conn);
$sql = "select Title as GameTitle from Game where GameId = '" . escapeString($GameId) ."'";
$result=mysql_query($sql);
while($row = mysql_fetch_array($result))
	{
	$GameTitle = $row['GameTitle'];
	}
}
mysql_close ($conn);

$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
if ($conn)
{
mysql_select_db($db, $conn);
$sql = "select GameType as Type from Game where GameId = '" . escapeString($GameId) . "'";
$result=mysql_query($sql);
while($row = mysql_fetch_array($result))
	{
	$GameType = $row['Type'];
	}
}
mysql_close ($conn);

if (count($UserChallengeArray) > 0 && $GameType == 'CTF')//error: the code here cannot find the proper GameId or ChallengeId, causing answered challenges to be able to answer again
{
	//echo $_GET["GameChallengeId"]; //<--Austin 9-28-17
	//echo $GameChallengeId;
	echo "<div class=\"alert alert-danger\">Oops! You have already answered this challenge!</div>";	//<--Original Code
}


elseif ($GameType == 'RvB')
{
	$timestamp = time();
	$UserChallengeSubmission = new UserChallengeSubmission();
	$UserChallengeSubmission->GameId = $GameId;
	$UserChallengeSubmission->ChallengeId = $ChallengeId;
	$UserChallengeSubmission->UserId = $UserId;
	$UserChallengeSubmission->Answer = strtoupper($Answer);
	$UserChallengeSubmission->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
	//$UserChallengeSubmission->GameChallengeId = $GameChallengeId; //GameChallengeId? GCID? //9-23-17 this line can break site
	$IsCorrect = 0;
	$PointValue = 0;
	//check for correct answer
	$ChallengeFactory = new ChallengeFactory();
	$Challenge = $ChallengeFactory->GetOne(escapeString($ChallengeId));
	if ($Challenge->ChallengeId > 0)
	{
		if ($Challenge->CorrectAnswer == $Answer)
		{
			$IsCorrect = 1;
			$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
			if ($conn)
			{
			mysql_select_db($db, $conn);
			$sql="UPDATE GameChallenges SET IsCorrect = 1 WHERE ChallengeId = " . escapeString($ChallengeId) . " AND GameId = " . escapeString($GameId);
			$results = mysql_query($sql);
			}
		}
		$PointValue = $Challenge->PointValue;
	}
	$UserChallengeSubmission->IsCorrect = $IsCorrect;
	$UserChallengeSubmissionFactory->Insert($UserChallengeSubmission);
	if ($UserChallengeSubmission->UserChallengeSubmissionId > 0)
	{
		$ProgressFactory = new ProgressFactory();
		$Progress = new Progress();
		$Progress->UserId = $UserId;
		$Progress->Username = $_SESSION["Username"];
		if ($IsCorrect == 1)
		{
			$Progress->Status = " just scored " . $PointValue . " points in the game " . $GameTitle;
		}
		else
		{
			$Progress->Status = " just submitted an incorrect answer for " . $PointValue . " points in the game " . $GameTitle;
		}
		$Progress->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
		//$Progress->GameChallengeId = $GameChallengeId; //9-23-17 this line can break site
		$Progress->GameId = $GameId;
		$Progress->ChallengeId = $ChallengeId;
		$ProgressFactory->Insert($Progress);
		if ($IsCorrect == 1)
		{
			echo "<div class=\"alert alert-success\">Boom, you just got $PointValue points!</div>";
			
		}
		else
		{
			echo "<div class=\"alert alert-danger\">Oops! You are wrong!</div>";
		}
	}
}


else
{
	$timestamp = time();
	$UserChallengeSubmission = new UserChallengeSubmission();
	$UserChallengeSubmission->GameId = $GameId;
	$UserChallengeSubmission->ChallengeId = $ChallengeId;
	$UserChallengeSubmission->UserId = $UserId;
	$UserChallengeSubmission->Answer = strtoupper($Answer);
	$UserChallengeSubmission->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
	//$UserChallengeSubmission->GameChallengeId = $GameChallengeId; //GameChallengeId? GCID? //9-23-17 this line can break site
	$IsCorrect = 0;
	$PointValue = 0;
	//check for correct answer
	$ChallengeFactory = new ChallengeFactory();
	$Challenge = $ChallengeFactory->GetOne(escapeString($ChallengeId));
	if ($Challenge->ChallengeId > 0)
	{
		if ($Challenge->CorrectAnswer == $Answer)
		{
			$IsCorrect = 1;
			
		}
		$PointValue = $Challenge->PointValue;
	}
	$UserChallengeSubmission->IsCorrect = $IsCorrect;
	$UserChallengeSubmissionFactory->Insert($UserChallengeSubmission);
	if ($UserChallengeSubmission->UserChallengeSubmissionId > 0)
	{
		$ProgressFactory = new ProgressFactory();
		$Progress = new Progress();
		$Progress->UserId = $UserId;
		$Progress->Username = $_SESSION["Username"];
		if ($IsCorrect == 1)
		{
			$Progress->Status = " just scored " . $PointValue . " points in the game " . $GameTitle;
		}
		else
		{
			$Progress->Status = " just submitted an incorrect answer for " . $PointValue . " points in the game " . $GameTitle;
		}
		$Progress->DateCreated = gmdate("Y-m-d H:i:s", $timestamp);
		//$Progress->GameChallengeId = $GameChallengeId; //9-23-17 this line can break site
		$Progress->GameId = $GameId;
		$Progress->ChallengeId = $ChallengeId;
		$ProgressFactory->Insert($Progress);
		if ($IsCorrect == 1)
		{
			echo "<div class=\"alert alert-success\">Boom, you just got $PointValue points!</div>";
			
		}
		else
		{
			echo "<div class=\"alert alert-danger\">Oops! You are wrong!</div>";
		}
	}
}
?>