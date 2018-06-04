<?php
//Usage
/*
<?php include 'Challenge.gen.php' ?>
<?php
$ChallengeFactory = new ChallengeFactory();
$Challenge = $ChallengeFactory->GetOne(1);
echo $Challenge->Title . "<br />";
unset($Challenge);
$ChallengeArray = $ChallengeFactory->GetAll(' where ChallengeId = 1 ');
foreach ($ChallengeArray as &$value)
{
	echo $value->Title . "<br />";
}
unset($value);
?>
*/
//Core Class
class Challenge
{
	var $ChallengeId;
	var $Title;
	var $GameId;
	//var $GameChallengeId; //<-- Austin 9-28-17
	var $Description;
	var $CorrectAnswer;
	var $SolvedByUserId;
	var $PointValue;
	var $IsComplete;
	var $IsOpen;
	var $Tags;

	function setChallengeId($ChallengeId) {
		$this->ChallengeId = $ChallengeId;
	}
	function getChallengeId() {
		return $this->ChallengeId;
	}

	function setTitle($Title) {
		$this->Title = $Title;
	}
	function getTitle() {
		return $this->Title;
	}

	function setGameId($GameId) {
		$this->GameId = $GameId;
	}
	function getGameId() {
		return $this->GameId;
	}

	function setGameChallengeId($GameChallengeId) {
		$this->GameChallengeId = $GameChallengeId;
	}
	function getGameChallengeId() {
		return $this->GameChallengeId;
	}

	function setDescription($Description) {
		$this->Description = $Description;
	}
	function getDescription() {
		return $this->Description;
	}

	function setCorrectAnswer($CorrectAnswer) {
		$this->CorrectAnswer = $CorrectAnswer;
	}
	function getCorrectAnswer() {
		return $this->CorrectAnswer;
	}

	function setSolvedByUserId($SolvedByUserId) {
		$this->SolvedByUserId = $SolvedByUserId;
	}
	function getSolvedByUserId() {
		return $this->SolvedByUserId;
	}

	function setPointValue($PointValue) {
		$this->PointValue = $PointValue;
	}
	function getPointValue() {
		return $this->PointValue;
	}

	function setIsComplete($IsComplete) {
		$this->IsComplete = $IsComplete;
	}
	function getIsComplete() {
		return $this->IsComplete;
	}

	function setIsOpen($IsOpen) {
		$this->IsOpen = $IsOpen;
	}
	function getIsOpen() {
		return $this->IsOpen;
	}

	function setTags($Tags) {
		$this->Tags = $Tags;
	}
	function getTags() {
		return $this->Tags;
	}
}
//Factory Class
class ChallengeFactory
{
	function GetOne($ChallengeId)
	{
		$Challenge = new Challenge();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from Challenge where ChallengeId = " . mysql_real_escape_string($ChallengeId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$Challenge->ChallengeId = $row['ChallengeId'];
				$Challenge->Title = $row['Title'];
				$Challenge->Description = $row['Description'];
				$Challenge->CorrectAnswer = $row['CorrectAnswer'];
				$Challenge->PointValue = $row['PointValue'];
				$Challenge->IsComplete = $row['IsComplete']; //<-- Austin 9-23-17
				$Challenge->IsOpen = $row['IsOpen']; //<-- Austin 9-23-17
				//$Challenge->IsComplete = ($row['IsComplete'] === NULL) ? "NULL" : $row['IsComplete']; <--Original Code
				//$Challenge->IsOpen = ($row['IsOpen'] === NULL) ? "NULL" : $row['IsOpen']; //<--Original Code
				$Challenge->Tags = $row['Tags'];
			}
		}
		mysql_close ($conn);
		return $Challenge;
	}

	/*function GetAll()
	{
		$ChallengeArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from Challenge";
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$Challenge = new Challenge();
				$Challenge->ChallengeId = $row['ChallengeId'];
				$Challenge->Title = $row['Title'];
				$Challenge->GameId = $row['GameId'];
				$Challenge->Description = $row['Description'];
				$Challenge->CorrectAnswer = $row['CorrectAnswer'];
				$Challenge->SolvedByUserId = ($row['SolvedByUserId'] === NULL) ? "" : $row['SolvedByUserId'];
				$Challenge->PointValue = $row['PointValue'];
				$Challenge->IsComplete = ($row['IsComplete'] === NULL) ? "" : $row['IsComplete'];
				$Challenge->IsOpen = ($row['IsOpen'] === NULL) ? "" : $row['IsOpen'];
				$Challenge->Tags = $row['Tags'];
				$ChallengeArray[] = $Challenge;
			}
		}
		mysql_close ($conn);
		return $ChallengeArray;
	}*/

	function GetAll($filter)
	{
		$ChallengeArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from Challenge " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$Challenge = new Challenge();
				$Challenge->ChallengeId = $row['ChallengeId'];
				$Challenge->Title = $row['Title'];
				$Challenge->Description = $row['Description'];
				$Challenge->CorrectAnswer = $row['CorrectAnswer'];
				$Challenge->PointValue = $row['PointValue'];
				$Challenge->IsComplete = $row['IsComplete']; //<--Austin 9-23-17
				$Challenge->IsOpen = $row['IsOpen']; //<--Austin 9-23-17
				//$Challenge->IsComplete = ($row['IsComplete'] === NULL) ? "" : $row['IsComplete']; //<--Original Code
				//$Challenge->IsOpen = ($row['IsOpen'] === NULL) ? "" : $row['IsOpen']; //<--Original Code
				$Challenge->Tags = $row['Tags'];
				$ChallengeArray[] = $Challenge;
			}
		}
		mysql_close ($conn);
		return $ChallengeArray;
	}
	function Insert($Challenge)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($Challenge->Title) . "',";
			$insert .= "'" . mysql_real_escape_string($Challenge->Description) . "',";
			$insert .= "'" . mysql_real_escape_string($Challenge->CorrectAnswer) . "',";
			$insert .= "'" . mysql_real_escape_string($Challenge->PointValue) . ",";
			$insert .= "'" . mysql_real_escape_string($Challenge->IsComplete) . ","; //<--Austin 9-23-17
			$insert .= "'" . mysql_real_escape_string($Challenge->IsOpen) . ","; //<--Austin 9-23-17
			//$insert .= (mysql_real_escape_string($Challenge->IsComplete) === "") ? "NULL," : mysql_real_escape_string($Challenge->IsComplete) . ","; //<--Original Code
			//$insert .= (mysql_real_escape_string($Challenge->IsOpen) === "") ? "NULL," : mysql_real_escape_string($Challenge->IsOpen) . ","; //<--Original Code
			$insert .= "'" . mysql_real_escape_string($Challenge->Tags) . "'";
			$sql = "insert into Challenge (Title,Description,CorrectAnswer,PointValue,IsComplete,IsOpen,Tags) values (" . $insert . ")";
			mysql_query($sql);
			$Challenge->ChallengeId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $Challenge;
	}
	function Update($Challenge)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Title = '" . mysql_real_escape_string($Challenge->Title) . "',";
			$update .= "Description = '" . mysql_real_escape_string($Challenge->Description) . "',";
			$update .= "CorrectAnswer = '" . mysql_real_escape_string($Challenge->CorrectAnswer) . "',";
			$update .= "PointValue = " . mysql_real_escape_string($Challenge->PointValue) . ",";
			$update .= "IsComplete = " . mysql_real_escape_string($Challenge->IsComplete) . "',"; //<--Austin 9-23-17
			$update .= "IsOpen = " . mysql_real_escape_string($Challenge->IsOpen) . "',"; //<--Austin 9-23-17
			//$update .= "IsComplete = " . ((mysql_real_escape_string($Challenge->IsComplete) === "") ? "NULL," : mysql_real_escape_string($Challenge->IsComplete) . ","); //<--Original Code
			//$update .= "IsOpen = " . ((mysql_real_escape_string($Challenge->IsOpen) === "") ? "NULL," : mysql_real_escape_string($Challenge->IsOpen) . ","); //<-- Original Code
			$update .= "Tags = '" . mysql_real_escape_string($Challenge->Tags) . "'";
			$sql = "update Challenge set " . $update . " where ChallengeId = " . mysql_real_escape_string($Challenge->ChallengeId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>
