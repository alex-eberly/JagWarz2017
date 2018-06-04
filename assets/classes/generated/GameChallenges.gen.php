<?php
//Usage
/*
<?php include 'GameChallenge.gen.php' ?>
<?php
$GameChallengeFactory = new GameChallengeFactory();
$GameChallenge = $GameChallengeFactory->GetOne(1);
echo $GameChallenge->GameId . "<br />";
unset($GameChallenge);
$GameChallengeArray = $GameChallengeFactory->GetAll(' where GameChallengeId = 1 ');
foreach ($GameChallengeArray as &$value)
{
	echo $value->GameId . "<br />";
}
unset($value);
?>
*/
//Core Class
class GameChallenge
{
	var $GameChallengeId;
	var $GameId;
	var $ChallengeId;
	var $RowPosition;
	
	function setGameChallengeId($GameChallengeId) {
		
		$this->GameChallengeId = $GameChallengeId;
	}
	function getGameChallengeId() {
		
		return $this->GameChallengeId;
	}
	function setGameId($GameId) {
		
		$this->GameId = $GameId;
	}
	function getGameId() {
		
		return $this->GameId;
	}
	function setChallengeId($ChallengeId) {
		
		$this->ChallengeId = $ChallengeId;
	}
	function getChallengeId() {
		
		return $this->ChallengeId;
	}
	function setRowPosition($RowPosition) {
		
		$this->RowPosition = $RowPosition;
	}
	function getRowPosition(){
		
		return $this->RowPosition;
	}
}
//Factory Class
class GameChallengeFactory
{
	function GetOne($GameChallengeId)
	{
		$GameChallenge = new GameChallenge();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from GameChallenges where GameChallengeId = " . mysql_real_escape_string($GameChallengeId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$GameChallenge->GameChallengeId = $row['GameChallengeId'];
				$GameChallenge->GameId = $row['GameId'];
				$GameChallenge->ChallengeId = $row['ChallengeId'];
				$GameChallenge->RowPosition = $row['RowPosition'];
			}
		}
		mysql_close ($conn);
		return $GameChallenge;
	}
	function GetAll($filter)
	{
		$GameChallengeArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select GameChallenges.GameChallengeId, Challenge.ChallengeId, Title, Description, CorrectAnswer, PointValue, IsComplete, IsOpen, Tags from Challenge INNER JOIN GameChallenges ON GameChallenges.ChallengeId = Challenge.ChallengeId " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$GameChallenge = new Challenge();
				$GameChallenge->ChallengeId = $row['ChallengeId'];
				$GameChallenge->Title = $row['Title'];
				$GameChallenge->Description = $row['Description'];
				$GameChallenge->CorrectAnswer = $row['CorrectAnswer'];
				$GameChallenge->PointValue = $row['PointValue'];
				$GameChallenge->IsComplete = $row['IsComplete'];
				$GameChallenge->IsOpen = $row['IsOpen'];
				//$GameChallenge->IsComplete = ($row['IsComplete'] === NULL) ? "" : $row['IsComplete']; // <-- Original Code, updated 10-13-17
				//$GameChallenge->IsOpen = ($row['IsOpen'] === NULL) ? "" : $row['IsOpen']; // <-- Original Code, updated 10-13-17
				$GameChallenge->Tags = $row['Tags'];
				$GameChallengeArray[] = $GameChallenge;
			}
		}
		mysql_close ($conn);
		return $GameChallengeArray;
	}
	function GetAllByGame($filter)
	{
		$GameChallengeArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from GameChallenges " . $filter;
			$result=mysql_query($sql);
			if($result === FALSE)
			{
				die(mysql_error());
			}
			while($row = mysql_fetch_array($result))
			{
				$GameChallenge = new GameChallenge();
				$GameChallenge->GameChallengeId = $row['GameChallengeId'];
				$GameChallenge->GameId = $row['GameId'];
				$GameChallenge->ChallengeId = $row['ChallengeId'];
				$GameChallenge->RowPosition = $row['RowPosition'];
				$GameChallengeArray[] = $GameChallenge;
			}
		}
		mysql_close ($conn);
		return $GameChallengeArray;
	}
	
	function Insert($GameChallenge)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= mysql_real_escape_string($GameChallenge->GameId) . ",";
			$insert .= mysql_real_escape_string($GameChallenge->ChallengeId) . ",";
			$insert .= mysql_real_escape_string($GameChallenge->RowPosition);
			$sql = "insert into GameChallenges (GameId,ChallengeId,RowPosition) values (" . $insert . ")";
			mysql_query($sql);
			$GameChallenge->GameChallengeId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $GameChallenge;
	}
	function Update($GameChallenge)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "GameId = " . mysql_real_escape_string($GameChallenge->GameId) . ",";
			$update .= "ChallengeId = " . mysql_real_escape_string($GameChallenge->ChallengeId) . ",";
			$update .= "RowPosition = " . mysql_real_escape_string($GameChallenge->RowPosition);
			$sql = "update GameChallenges set " . $update . " where GameChallengeId = " . mysql_real_escape_string($GameChallenge->GameChallengeId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>