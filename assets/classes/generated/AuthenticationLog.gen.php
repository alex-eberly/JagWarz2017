<?php
//Usage
/*
<?php include 'AuthenticationLog.gen.php' ?>
<?php
$AuthenticationLogFactory = new AuthenticationLogFactory();
$AuthenticationLog = $AuthenticationLogFactory->GetOne(1);
echo $AuthenticationLog->Username . "<br />";
unset($AuthenticationLog);
$AuthenticationLogArray = $AuthenticationLogFactory->GetAll(' where LogId = 1 ');
foreach ($AuthenticationLogArray as &$value)
{
	echo $value->Username . "<br />";
}
unset($value);
?>
*/
//Core Class
class AuthenticationLog
{
	var $LogId;
	var $Username;
	var $IsSuccess;
	var $DateCreated;
	function setLogId($LogId)
	{
		$this->LogId = $LogId;
	}
	function getLogId()
	{
		return $this->LogId;
	}
	function setUsername($Username)
	{
		$this->Username = $Username;
	}
	function getUsername()
	{
		return $this->Username;
	}
	function setIsSuccess($IsSuccess)
	{
		$this->IsSuccess = $IsSuccess;
	}
	function getIsSuccess()
	{
		return $this->IsSuccess;
	}
	function setDateCreated($DateCreated)
	{
		$this->DateCreated = $DateCreated;
	}
	function getDateCreated()
	{
		return $this->DateCreated;
	}
}
//Factory Class
class AuthenticationLogFactory
{
	function GetOne($LogId)
	{
		$AuthenticationLog = new AuthenticationLog();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from AuthenticationLog where LogId = " . mysql_real_escape_string($LogId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$AuthenticationLog->LogId = $row['LogId'];
				$AuthenticationLog->Username = $row['Username'];
				$AuthenticationLog->IsSuccess = $row['IsSuccess'];
				$AuthenticationLog->DateCreated = $row['DateCreated'];
			}
		}
		mysql_close ($conn);
		return $AuthenticationLog;
	}
	function GetAll($filter)
	{
		$AuthenticationLogArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from AuthenticationLog " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$AuthenticationLog = new AuthenticationLog();
				$AuthenticationLog->LogId = $row['LogId'];
				$AuthenticationLog->Username = $row['Username'];
				$AuthenticationLog->IsSuccess = $row['IsSuccess'];
				$AuthenticationLog->DateCreated = $row['DateCreated'];
				$AuthenticationLogArray[] = $AuthenticationLog;
			}
		}
		mysql_close ($conn);
		return $AuthenticationLogArray;
	}
	function Insert($AuthenticationLog)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($AuthenticationLog->Username) . "',";
			$insert .= mysql_real_escape_string($AuthenticationLog->IsSuccess) . ",";
			$insert .= mysql_real_escape_string($AuthenticationLog->DateCreated);
			$sql = "insert into AuthenticationLog (Username,IsSuccess,DateCreated) values (" . $insert . ")";
			mysql_query($sql);
			$AuthenticationLog->LogId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $AuthenticationLog;
	}
	function Update($AuthenticationLog)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Username = '" . mysql_real_escape_string($AuthenticationLog->Username) . "',";
			$update .= "IsSuccess = " . mysql_real_escape_string($AuthenticationLog->IsSuccess) . ",";
			$update .= "DateCreated = " . mysql_real_escape_string($AuthenticationLog->DateCreated);
			$sql = "update AuthenticationLog set " . $update . " where LogId = " . mysql_real_escape_string($AuthenticationLog->LogId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>