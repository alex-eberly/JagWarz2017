<?php
//Usage
/*
<?php include 'AdminUser.gen.php' ?>
<?php
$AdminUserFactory = new AdminUserFactory();
$AdminUser = $AdminUserFactory->GetOne(1);
echo $AdminUser->Username . "<br />";
unset($AdminUser);
$AdminUserArray = $AdminUserFactory->GetAll(' where AdminUserId = 1 ');
foreach ($AdminUserArray as &$value)
{
	echo $value->Username . "<br />";
}
unset($value);
?>
*/
//Core Class
class AdminUser
{
	var $AdminUserId;
	var $Username;
	var $Password;
	function setAdminUserId($AdminUserId)
	{
		$this->AdminUserId = $AdminUserId;
	}
	function getAdminUserId()
	{
		return $this->AdminUserId;
	}
	function setUsername($Username)
	{
		$this->Username = $Username;
	}
	function getUsername()
	{
		return $this->Username;
	}
	function setPassword($Password)
	{
		$this->Password = $Password;
	}
	function getPassword()
	{
		return $this->Password;
	}
}
//Factory Class
class AdminUserFactory
{
	function GetOne($AdminUserId)
	{
		$AdminUser = new AdminUser();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from AdminUser where AdminUserId = " . mysql_real_escape_string($AdminUserId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$AdminUser->AdminUserId = $row['AdminUserId'];
				$AdminUser->Username = $row['Username'];
				$AdminUser->Password = $row['Password'];
			}
		}
		mysql_close ($conn);
		return $AdminUser;
	}
	function GetAll($filter)
	{
		$AdminUserArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from AdminUser " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$AdminUser = new AdminUser();
				$AdminUser->AdminUserId = $row['AdminUserId'];
				$AdminUser->Username = $row['Username'];
				$AdminUser->Password = $row['Password'];
				$AdminUserArray[] = $AdminUser;
			}
		}
		mysql_close ($conn);
		return $AdminUserArray;
	}
	function Insert($AdminUser)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($AdminUser->Username) . "',";
			$insert .= "'" . mysql_real_escape_string($AdminUser->Password) . "'";
			$sql = "insert into AdminUser (Username,Password) values (" . $insert . ")";
			mysql_query($sql);
			$AdminUser->AdminUserId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $AdminUser;
	}
	function Update($AdminUser)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Username = '" . mysql_real_escape_string($AdminUser->Username) . "',";
			$update .= "Password = '" . mysql_real_escape_string($AdminUser->Password) . "'";
			$sql = "update AdminUser set " . $update . " where AdminUserId = " . mysql_real_escape_string($AdminUser->AdminUserId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>