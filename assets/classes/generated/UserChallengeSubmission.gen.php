<?php
//Usage
/*
<?php include 'UserChallengeSubmission.gen.php' ?>
<?php
$UserChallengeSubmissionFactory = new UserChallengeSubmissionFactory();
$UserChallengeSubmission = $UserChallengeSubmissionFactory->GetOne(1);
echo $UserChallengeSubmission->UserId . "<br />";
unset($UserChallengeSubmission);
$UserChallengeSubmissionArray = $UserChallengeSubmissionFactory->GetAll(' where UserChallengeSubmissionId = 1 ');
foreach ($UserChallengeSubmissionArray as &$value)
{
	echo $value->UserId . "<br />";
}
unset($value);
?>
*/
//Core Class
class UserChallengeSubmission
{
	var $UserChallengeSubmissionId;
	var $UserId;
	var $ChallengeId;
	var $Answer;
	var $IsCorrect;
	var $DateCreated;
	var $GameId;
	var $GameChallengeId; //Starting from here, the commented out code is the code meant for integration that failed
	function setUserChallengeSubmissionId($UserChallengeSubmissionId)
	{
		$this->UserChallengeSubmissionId = $UserChallengeSubmissionId;
	}
	function getUserChallengeSubmissionId()
	{
		return $this->UserChallengeSubmissionId;
	}
	function setUserId($UserId)
	{
		$this->UserId = $UserId;
	}
	function getUserId()
	{
		return $this->UserId;
	}
	function setChallengeId($ChallengeId)
	{
		$this->ChallengeId = $ChallengeId;
	}
	function getChallengeId()
	{
		return $this->ChallengeId;
	}
	function setAnswer($Answer)
	{
		$Answer = strtoupper($Answer);
		$this->Answer = $Answer;
	}
	function getAnswer()
	{
		return $this->Answer;
	}
	function setIsCorrect($IsCorrect)
	{
		$this->IsCorrect = $IsCorrect;
	}
	function getIsCorrect()
	{
		return $this->IsCorrect;
	}
	function setDateCreated($DateCreated)
	{
		$this->DateCreated = $DateCreated;
	}
	function getDateCreated()
	{
		return $this->DateCreated;
	}
	function setGameId($GameId)
	{
		$this->GameId = $GameId;
	}
	function getGameId()
	{
		return $this->GameId;
	}
	function setGameChallengeId($GameChallengeId)
	{
		$this->GameChallengeId = $GameChallengeId;
	}
	function getGameChallengeId()
	{
		return $this->GameChallengeId;
	}
}
//Factory Class
class UserChallengeSubmissionFactory
{
	function GetOne($UserChallengeSubmissionId)
	{
		$UserChallengeSubmission = new UserChallengeSubmission();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from UserChallengeSubmission where UserChallengeSubmissionId = " . mysql_real_escape_string($UserChallengeSubmissionId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$UserChallengeSubmission->UserChallengeSubmissionId = $row['UserChallengeSubmissionId'];
				$UserChallengeSubmission->UserId = $row['UserId'];
				$UserChallengeSubmission->ChallengeId = $row['ChallengeId'];
				$UserChallengeSubmission->Answer = strtoupper($row['Answer']);
				$UserChallengeSubmission->IsCorrect = $row['IsCorrect'];
				$UserChallengeSubmission->DateCreated = $row['DateCreated'];
				$UserChallengeSubmission->GameId = $row['GameId'];
				$UserChallengeSubmission->GameChallengeId = $row['GameChallengeId'];
			}
		}
		mysql_close ($conn);
		return $UserChallengeSubmission;
	}
	function GetAll($filter)
	{
		$UserChallengeSubmissionArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from UserChallengeSubmission " . $filter;
			//$alter = "select GameChallengeId from GameChallenges as gc(select c.ChallengeId, g.GameId Challenge as c, Game as g where c.ChallengeId = gc.ChallengeId and g.GameId = gc.GameChallengeId) = " . mysql_real_escape_string($GameChallengeId);
			
			
			$result=mysql_query($sql);
			if($result === FALSE)
			{
				die(mysql_error());
			}
			while($row = mysql_fetch_array($result))
			{
				$UserChallengeSubmission = new UserChallengeSubmission();
				$UserChallengeSubmission->UserChallengeSubmissionId = $row['UserChallengeSubmissionId'];
				$UserChallengeSubmission->UserId = $row['UserId'];
				$UserChallengeSubmission->ChallengeId = $row['ChallengeId'];
				$UserChallengeSubmission->Answer = strtoupper($row['Answer']);
				$UserChallengeSubmission->IsCorrect = $row['IsCorrect'];
				$UserChallengeSubmission->DateCreated = $row['DateCreated'];
				$UserChallengeSubmission->GameId = $row['GameId'];
				$UserChallengeSubmission->GameChallengeId = $row['GameChallengeId'];//error not referring to this GameChallengeId
				$UserChallengeSubmissionArray[] = $UserChallengeSubmission;
			}
		}
		mysql_close ($conn);
		return $UserChallengeSubmissionArray;
	}
	function Insert($UserChallengeSubmission)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($UserChallengeSubmission->UserId) . "',";
			$insert .= "'" . mysql_real_escape_string($UserChallengeSubmission->ChallengeId) . "',";
			$insert .= "'" . strtoupper(mysql_real_escape_string($UserChallengeSubmission->Answer)) . "',";
			$insert .= "'" . mysql_real_escape_string($UserChallengeSubmission->IsCorrect) . "',";
			$insert .= "'" . mysql_real_escape_string($UserChallengeSubmission->DateCreated) . "',";
			$insert .= "'" . mysql_real_escape_string($UserChallengeSubmission->GameId) . "'";
			$insert .= "'" . mysql_real_escape_string($UserChallengeSubmission->GameChallengeId) . "'"; 
			$sql = "insert into UserChallengeSubmission (UserId,ChallengeId,Answer,IsCorrect,DateCreated,GameId) values (" . $insert . ")";//9-23-17 adding GameChallengeId breaks the site
			mysql_query($sql);
			$UserChallengeSubmission->UserChallengeSubmissionId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $UserChallengeSubmission;
	}
	function Update($UserChallengeSubmission)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "UserId = '" . mysql_real_escape_string($UserChallengeSubmission->UserId) . "',";
			$update .= "ChallengeId = '" . mysql_real_escape_string($UserChallengeSubmission->ChallengeId) . "',";
			$update .= "Answer = '" . mysql_real_escape_string($UserChallengeSubmission->Answer) . "',";
			$update .= "IsCorrect = '" . mysql_real_escape_string($UserChallengeSubmission->IsCorrect) . "',";
			$update .= "DateCreated = '" . mysql_real_escape_string($UserChallengeSubmission->DateCreated) . "',";
			$update .= "GameId = '" . mysql_real_escape_string($UserChallengeSubmission->GameId) . "'";
			$update .= "GameChallengeId = '" . mysql_real_escape_string($UserChallengeSubmission->GameChallengeId) . "'";
			$sql = "update UserChallengeSubmission set " . $update . " where UserChallengeSubmissionId = " . mysql_real_escape_string($UserChallengeSubmission->UserChallengeSubmissionId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>