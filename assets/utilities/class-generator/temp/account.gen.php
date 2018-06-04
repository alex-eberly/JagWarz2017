<?php
//Globals
$dbserver = "localhost";
$db = "mlindle_pledgeforge";
$dbuser = "mlindle_dbuser";
$dbpassword = "zombiept2";
//Usage
/*
<?php include 'account.gen.php' ?>
<?php
$accountFactory = new accountFactory();
$account = $accountFactory->GetOne(1);
echo $account->Name . "<br />";
unset($account);
$accountArray = $accountFactory->GetAll(' where AccountId = 1 ');
foreach ($accountArray as &$value)
{
	echo $value->Name . "<br />";
}
unset($value);
?>
*/
//Core Class
class account
{
	var $AccountId;
	var $Name;
	var $DateCreated;
	function setAccountId($AccountId)
	{
		$this->AccountId = $AccountId;
	}
	function getAccountId()
	{
		return $this->AccountId;
	}
	function setName($Name)
	{
		$this->Name = $Name;
	}
	function getName()
	{
		return $this->Name;
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
class accountFactory
{
	function GetOne($AccountId)
	{
		$account = new account();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from account where AccountId = " . mysql_real_escape_string($AccountId);
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$account->AccountId = $row['AccountId'];
				$account->Name = $row['Name'];
				$account->DateCreated = $row['DateCreated'];
			}
		}
		mysql_close ($conn);
		return $account;
	}
	function GetAll($filter)
	{
		$accountArray = Array();
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$sql = "select * from account " . $filter;
			$result=mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				$account = new account();
				$account->AccountId = $row['AccountId'];
				$account->Name = $row['Name'];
				$account->DateCreated = $row['DateCreated'];
				$accountArray[] = $account;
			}
		}
		mysql_close ($conn);
		return $accountArray;
	}
	function Insert($account)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$insert = "";
			$insert .= "'" . mysql_real_escape_string($account->Name) . "',";
			$insert .= "'" . mysql_real_escape_string($account->DateCreated) . "'";
			$sql = "insert into account (Name,DateCreated) values (" . $insert . ")";
			mysql_query($sql);
			$account->AccountId = mysql_insert_id();
		}
		mysql_close ($conn);
		return $account;
	}
	function Update($account)
	{
		global $dbserver,$db,$dbuser,$dbpassword;
		$conn = mysql_connect($dbserver,$dbuser,$dbpassword);
		if ($conn)
		{
			mysql_select_db($db, $conn);
			$update = "";
			$update .= "Name = '" . mysql_real_escape_string($account->Name) . "',";
			$update .= "DateCreated = '" . mysql_real_escape_string($account->DateCreated) . "'";
			$sql = "update account set " . $update . " where AccountId = " . mysql_real_escape_string($account->AccountId);
			mysql_query($sql);
		}
		mysql_close ($conn);
	}
}
?>