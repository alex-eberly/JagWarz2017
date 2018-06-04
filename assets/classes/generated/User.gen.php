<?php
//Usage
/*
<?php include 'User.gen.php' ?>
<?php
$UserFactory = new UserFactory();
$User = $UserFactory->GetOne(1);
echo $User->Password . "<br />";
unset($User);
$UserArray = $UserFactory->GetAll(' where UserId = 1 ');
foreach ($UserArray as &$value)
{
	echo $value->Password . "<br />";
}
unset($value);
?>
*/
//Core Class
class User
{
	var $UserId;
	var $Password;
	var $Firstname;
	var $Lastname;
	var $Email;
	var $IsActive;
	var $DateCreated;
	var $Username;
	function setUserId($UserId)
	{
		$this->UserId = $UserId;
	}
	function getUserId()
	{
		return $this->UserId;
	}
	function setPassword($Password)
	{
		$this->Password = $Password;
	}
	function getPassword()
	{
		return $this->Password;
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
	function setIsActive($IsActive)
	{
		$this->IsActive = $IsActive;
	}
	function getIsActive()
	{
		return $this->IsActive;
	}
	function setDateCreated($DateCreated)
	{
		$this->DateCreated = $DateCreated;
	}
	function getDateCreated()
	{
		return $this->DateCreated;
	}
	function setUsername($Username)
	{
		$this->Username = $Username;
	}
	function getUsername()
	{
		return $this->Username;
	}
}
//Factory Class
class UserFactory
{
	function GetOne($UserId)
	{
		$User = new User();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from User where UserId = " . mysql_real_escape_string($UserId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$User->UserId = $row['UserId'];
				$User->Password = $row['Password'];
				$User->Firstname = $row['Firstname'];
				$User->Lastname = $row['Lastname'];
				$User->Email = $row['Email'];
				$User->IsActive = $row['IsActive'];
				$User->DateCreated = $row['DateCreated'];
				$User->Username = $row['Username'];
			}
		}
		mysql_close ($conn);
		return $User;
	}
	function GetAll($filter)
	{
		$UserArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from User " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$User = new User();
				$User->UserId = $row['UserId'];
				$User->Password = $row['Password'];
				$User->Firstname = $row['Firstname'];
				$User->Lastname = $row['Lastname'];
				$User->Email = $row['Email'];
				$User->IsActive = $row['IsActive'];
				$User->DateCreated = $row['DateCreated'];
				$User->Username = $row['Username'];
				$UserArray[] = $User;
			}
		}
		mysql_close ($conn);
		return $UserArray;
	}
	function Insert($User)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($User->Password) . "',";
			$insert .= "'" . mysql_real_escape_string($User->Firstname) . "',";
			$insert .= "'" . mysql_real_escape_string($User->Lastname) . "',";
			$insert .= "'" . mysql_real_escape_string($User->Email) . "',";
			$insert .= mysql_real_escape_string($User->IsActive) . ",";
			$insert .= "'" . mysql_real_escape_string($User->DateCreated) . "',";
			$insert .= "'" . mysql_real_escape_string($User->Username) . "'";
			$sql = "insert into User (Password,Firstname,Lastname,Email,IsActive,DateCreated,Username) values (" . $insert . ")";
			mysql_query($sql);
			$User->UserId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $User;
	}
	function Update($User)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Password = '" . mysql_real_escape_string($User->Password) . "',";
			$update .= "Firstname = '" . mysql_real_escape_string($User->Firstname) . "',";
			$update .= "Lastname = '" . mysql_real_escape_string($User->Lastname) . "',";
			$update .= "Email = '" . mysql_real_escape_string($User->Email) . "',";
			$update .= "IsActive = " . mysql_real_escape_string($User->IsActive) . ",";
			$update .= "DateCreated = '" . mysql_real_escape_string($User->DateCreated) . "',";
			$update .= "Username = '" . mysql_real_escape_string($User->Username) . "'";
			$sql = "update User set " . $update . " where UserId = " . mysql_real_escape_string($User->UserId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>