<?php
//Usage
/*
<?php include 'Progress.gen.php' ?>
<?php
$ProgressFactory = new ProgressFactory();
$Progress = $ProgressFactory->GetOne(1);
echo $Progress->UserId . "<br />";
unset($Progress);
$ProgressArray = $ProgressFactory->GetAll(' where ProgressId = 1 ');
foreach ($ProgressArray as &$value)
{
	echo $value->UserId . "<br />";
}
unset($value);
?>
*/
//Core Class
class Progress
{
	var $ProgressId;
	var $UserId;
	var $Username;
	var $Status;
	var $DateCreated;
	var $GameId;
	var $ChallengeId;
	var $GameChallengeId;  //Starting from here, the commented out code is the code meant for integration that failed
	function setProgressId($ProgressId)
	{
		$this->ProgressId = $ProgressId;
	}
	function getProgressId()
	{
		return $this->ProgressId;
	}
	function setUserId($UserId)
	{
		$this->UserId = $UserId;
	}
	function getUserId()
	{
		return $this->UserId;
	}
	function setUsername($Username)
	{
		$this->Username = $Username;
	}
	function getUsername()
	{
		return $this->Username;
	}
	function setStatus($Status)
	{
		$this->Status = $Status;
	}
	function getStatus()
	{
		return $this->Status;
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
	function setChallengeId($ChallengeId)
	{
		$this->ChallengeId = $ChallengeId;
	}
	function getChallengeId()
	{
		return $this->ChallengeId;
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
class ProgressFactory
{
	function GetOne($ProgressId)
	{
		$Progress = new Progress();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from Progress where ProgressId = " . mysql_real_escape_string($ProgressId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$Progress->ProgressId = $row['ProgressId'];
				$Progress->UserId = $row['UserId'];
				$Progress->Username = $row['Username'];
				$Progress->Status = $row['Status'];
				$Progress->DateCreated = $row['DateCreated'];
				$Progress->GameId = $row['GameId'];
				$Progress->ChallengeId = $row['ChallengeId'];
				$Progress->GameChallengeId = $row['GameChallengeId'];
			}
		}
		mysql_close ($conn);
		return $Progress;
	}
	function GetAll($filter)
	{
		$ProgressArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from Progress " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$Progress = new Progress();
				$Progress->ProgressId = $row['ProgressId'];
				$Progress->UserId = $row['UserId'];
				$Progress->Username = $row['Username'];
				$Progress->Status = $row['Status'];
				$Progress->DateCreated = $row['DateCreated'];
				$Progress->GameId = $row['GameId'];
				$Progress->ChallengeId = $row['ChallengeId'];
				//$Progress->GameChallengeId = $row['GameChallengeId'];
				$ProgressArray[] = $Progress;
			}
		}
		mysql_close ($conn);
		return $ProgressArray;
	}
	function Insert($Progress)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= mysql_real_escape_string($Progress->UserId) . ",";
			$insert .= "'" . mysql_real_escape_string($Progress->Username) . "',";
			$insert .= "'" . mysql_real_escape_string($Progress->Status) . "',";
			$insert .= "'" . mysql_real_escape_string($Progress->DateCreated) . "',";
			$insert .= mysql_real_escape_string($Progress->GameId) . ",";
			$insert .= mysql_real_escape_string($Progress->ChallengeId);
			$insert .= mysql_real_escape_string($Progress->GameChallengeId); //Also remember GameChallengeId goes in below paranthesis
			$sql = "insert into Progress (UserId,Username,Status,DateCreated,GameId,ChallengeId) values (" . $insert . ")"; //9-23-17 adding GameChallengeId breaks site
			mysql_query($sql);
			$Progress->ProgressId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $Progress;
	}
	function Update($Progress)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "UserId = '" . mysql_real_escape_string($Progress->UserId) . "',";
			$update .= "Username = '" . mysql_real_escape_string($Progress->Username) . "',";
			$update .= "Status = '" . mysql_real_escape_string($Progress->Status) . "',";
			$update .= "DateCreated = '" . mysql_real_escape_string($Progress->DateCreated) . "',";
			$update .= "GameId = '" . mysql_real_escape_string($Progress->GameId) . "',";
			$update .= "ChallengeId = '" . mysql_real_escape_string($Progress->ChallengeId) . "'";
			$update .= "GameChallengeId = '" . mysql_real_escape_string($Progress->GameChallengeId) . "'";
			$sql = "update Progress set " . $update . " where ProgressId = " . mysql_real_escape_string($Progress->ProgressId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>