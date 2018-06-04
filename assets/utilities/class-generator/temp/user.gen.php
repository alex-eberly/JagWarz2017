<?php
//Globals
$dbserver = "localhost";
$db = "mlindle_pledgeforge";
$dbuser = "mlindle_dbuser";
$dbpassword = "zombiept2";
//Usage
/*
<?php include 'user.gen.php' ?>
<?php
$userFactory = new userFactory();
$user = $userFactory->GetOne(1);
echo $user->AccountId . "<br />";
unset($user);
$userArray = $userFactory->GetAll(' where UserId = 1 ');
foreach ($userArray as &$value)
{
	echo $value->AccountId . "<br />";
}
unset($value);
?>
*/
//Core Class
class user
{
	var $UserId;
	var $AccountId;
	var $Firstname;
	var $Lastname;
	var $Email;
	var $Password;
	var $DateCreated;
	function setUserId($UserId)
	{
		$this->UserId = $UserId;
	}
	function getUserId()
	{
		return $this->UserId;
	}
	function setAccountId($AccountId)
	{
		$this->AccountId = $AccountId;
	}
	function getAccountId()
	{
		return $this->AccountId;
	}
	function setFirstname($Firstname)
	{
		$this->Firstname = $Firstname;
	}
	function getFirstname()
	{
		return $this->Firstname;
	}
	function setLastname($Lastname)
	{
		$this->Lastname = $Lastname;
	}
	function getLastname()
	{
		return $this->Lastname;
	}
	function setEmail($Email)
	{
		$this->Email = $Email;
	}
	function getEmail()
	{
		return $this->Email;
	}
	function setPassword($Password)
	{
		$this->Password = $Password;
	}
	function getPassword()
	{
		return $this->Password;
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
class userFactory
{
	function GetOne($UserId)
	{
		$user = new user();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from user where UserId = " . mysql_real_escape_string($UserId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$user->UserId = $row['UserId'];
				$user->AccountId = $row['AccountId'];
				$user->Firstname = $row['Firstname'];
				$user->Lastname = $row['Lastname'];
				$user->Email = $row['Email'];
				$user->Password = $row['Password'];
				$user->DateCreated = $row['DateCreated'];
			}
		}
		mysql_close ($conn);
		return $user;
	}
	function GetAll($filter)
	{
		$userArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from user " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$user = new user();
				$user->UserId = $row['UserId'];
				$user->AccountId = $row['AccountId'];
				$user->Firstname = $row['Firstname'];
				$user->Lastname = $row['Lastname'];
				$user->Email = $row['Email'];
				$user->Password = $row['Password'];
				$user->DateCreated = $row['DateCreated'];
				$userArray[] = $user;
			}
		}
		mysql_close ($conn);
		return $userArray;
	}
	function Insert($user)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= mysql_real_escape_string($user->AccountId) . ",";
			$insert .= "'" . mysql_real_escape_string($user->Firstname) . "',";
			$insert .= "'" . mysql_real_escape_string($user->Lastname) . "',";
			$insert .= "'" . mysql_real_escape_string($user->Email) . "',";
			$insert .= "'" . mysql_real_escape_string($user->Password) . "',";
			$insert .= "'" . mysql_real_escape_string($user->DateCreated) . "'";
			$sql = "insert into user (AccountId,Firstname,Lastname,Email,Password,DateCreated) values (" . $insert . ")";
			mysql_query($sql);
			$user->UserId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $user;
	}
	function Update($user)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "AccountId = " . mysql_real_escape_string($user->AccountId) . ",";
			$update .= "Firstname = '" . mysql_real_escape_string($user->Firstname) . "',";
			$update .= "Lastname = '" . mysql_real_escape_string($user->Lastname) . "',";
			$update .= "Email = '" . mysql_real_escape_string($user->Email) . "',";
			$update .= "Password = '" . mysql_real_escape_string($user->Password) . "',";
			$update .= "DateCreated = '" . mysql_real_escape_string($user->DateCreated) . "'";
			$sql = "update user set " . $update . " where UserId = " . mysql_real_escape_string($user->UserId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>