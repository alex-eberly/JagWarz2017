<?php
//Usage
/*
<?php include 'LogAuthentication.gen.php' ?>
<?php
$LogAuthenticationFactory = new LogAuthenticationFactory();
$LogAuthentication = $LogAuthenticationFactory->GetOne(1);
echo $LogAuthentication->Username . "<br />";
unset($LogAuthentication);
$LogAuthenticationArray = $LogAuthenticationFactory->GetAll(' where AuthenticationLogId = 1 ');
foreach ($LogAuthenticationArray as &$value)
{
	echo $value->Username . "<br />";
}
unset($value);
?>
*/
//Core Class
class LogAuthentication
{
	var $AuthenticationLogId;
	var $Username;
	var $IpAddress;
	var $Successful;
	var $DateCreated;
	function setAuthenticationLogId($AuthenticationLogId)
	{
		$this->AuthenticationLogId = $AuthenticationLogId;
	}
	function getAuthenticationLogId()
	{
		return $this->AuthenticationLogId;
	}
	function setUsername($Username)
	{
		$this->Username = $Username;
	}
	function getUsername()
	{
		return $this->Username;
	}
	function setIpAddress($IpAddress)
	{
		$this->IpAddress = $IpAddress;
	}
	function getIpAddress()
	{
		return $this->IpAddress;
	}
	function setSuccessful($Successful)
	{
		$this->Successful = $Successful;
	}
	function getSuccessful()
	{
		return $this->Successful;
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
class LogAuthenticationFactory
{
	function GetOne($AuthenticationLogId)
	{
		$LogAuthentication = new LogAuthentication();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from LogAuthentication where AuthenticationLogId = " . mysql_real_escape_string($AuthenticationLogId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$LogAuthentication->AuthenticationLogId = $row['AuthenticationLogId'];
				$LogAuthentication->Username = $row['Username'];
				$LogAuthentication->IpAddress = $row['IpAddress'];
				$LogAuthentication->Successful = $row['Successful'];
				$LogAuthentication->DateCreated = $row['DateCreated'];
			}
		}
		mysql_close ($conn);
		return $LogAuthentication;
	}
	function GetAll($filter)
	{
		$LogAuthenticationArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from LogAuthentication " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$LogAuthentication = new LogAuthentication();
				$LogAuthentication->AuthenticationLogId = $row['AuthenticationLogId'];
				$LogAuthentication->Username = $row['Username'];
				$LogAuthentication->IpAddress = $row['IpAddress'];
				$LogAuthentication->Successful = $row['Successful'];
				$LogAuthentication->DateCreated = $row['DateCreated'];
				$LogAuthenticationArray[] = $LogAuthentication;
			}
		}
		mysql_close ($conn);
		return $LogAuthenticationArray;
	}
	function Insert($LogAuthentication)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($LogAuthentication->Username) . "',";
			$insert .= "'" . mysql_real_escape_string($LogAuthentication->IpAddress) . "',";
			$insert .= mysql_real_escape_string($LogAuthentication->Successful) . ",";
			$insert .= "'" . mysql_real_escape_string($LogAuthentication->DateCreated) . "'";
			$sql = "insert into LogAuthentication (Username,IpAddress,Successful,DateCreated) values (" . $insert . ")";
			mysql_query($sql);
			$LogAuthentication->AuthenticationLogId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $LogAuthentication;
	}
	function Update($LogAuthentication)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Username = '" . mysql_real_escape_string($LogAuthentication->Username) . "',";
			$update .= "IpAddress = '" . mysql_real_escape_string($LogAuthentication->IpAddress) . "',";
			$update .= "Successful = " . mysql_real_escape_string($LogAuthentication->Successful) . ",";
			$update .= "DateCreated = '" . mysql_real_escape_string($LogAuthentication->DateCreated) . "'";
			$sql = "update LogAuthentication set " . $update . " where AuthenticationLogId = " . mysql_real_escape_string($LogAuthentication->AuthenticationLogId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>