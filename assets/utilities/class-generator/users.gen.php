<?php
//Globals
$dbserver = "localhost";
$db = "test";
$user = "root";
$password = "";
//Usage
/*
<?php include 'users.gen.php' ?>
<?php
$usersFactory = new usersFactory();
$users = $usersFactory->GetOne(1);
echo $users->Username . "<br />";
unset($users);
$usersArray = $usersFactory->GetAll(' where UserId = 1 ');
foreach ($usersArray as &$value)
{
	echo $value->Username . "<br />";
}
unset($value);
?>
*/
//Core Class
class users
{
	var $UserId;
	var $Username;
	var $Firstname;
	var $Lastname;
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
}
//Factory Class
class usersFactory
{
	function GetOne($UserId)
	{
		$users = new users();
		global $dbserver,$db,$user,$password;
		$conn = mysql_connect($dbserver,$user,$password);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from users where UserId = $UserId";
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$users->UserId = $row['UserId'];
				$users->Username = $row['Username'];
				$users->Firstname = $row['Firstname'];
				$users->Lastname = $row['Lastname'];
			}
		}
		mysql_close ($conn);
		return $users;
	}
	function GetAll($filter)
	{
		$usersArray = Array();
		global $dbserver,$db,$user,$password;
		$conn = mysql_connect($dbserver,$user,$password);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from users $filter";
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$users = new users();
				$users->UserId = $row['UserId'];
				$users->Username = $row['Username'];
				$users->Firstname = $row['Firstname'];
				$users->Lastname = $row['Lastname'];
				$usersArray[] = $users;
			}
		}
		mysql_close ($conn);
		return $usersArray;
	}
	function Insert($users)
	{
		global $dbserver,$db,$user,$password;
		$conn = mysql_connect($dbserver,$user,$password);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . $users->Username . "',";
			$insert .= "'" . $users->Firstname . "',";
			$insert .= "'" . $users->Lastname . "'";
			$sql = "insert into users (Username,Firstname,Lastname) values (" . $insert . ")";
			mysql_query($sql);
			$users->UserId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $users;
	}
	function Update($users)
	{
		global $dbserver,$db,$user,$password;
		$conn = mysql_connect($dbserver,$user,$password);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Username = '" . $users->Username . "',";
			$update .= "Firstname = '" . $users->Firstname . "',";
			$update .= "Lastname = '" . $users->Lastname . "'";
			$sql = "update users set " . $update . " where UserId = " . $users->UserId;
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>